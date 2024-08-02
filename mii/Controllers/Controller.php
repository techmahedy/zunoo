<?php

namespace Mii\Controllers;

use Closure;
use Countable;
use RuntimeException;
use InvalidArgumentException;

class Controller
{
    // Properties to store various configuration settings and data
    protected $fileExtension; // File extension for template files
    protected $viewFolder; // Directory where view files are stored
    protected $cacheFolder; // Directory where cached files are stored
    protected $echoFormat; // Format for echoing variables in templates
    protected $extensions = []; // Array to store custom extensions
    protected $templates = []; // Array to store compiled templates

    protected static $directives = []; // Static array to store custom directives

    // Properties to manage blocks, block stacks, loop stacks, and other states
    protected $blocks = []; // Array to store content blocks
    protected $blockStacks = []; // Array to manage nested blocks
    protected $loopStacks = []; // Array to manage nested loops
    protected $emptyCounter = 0; // Counter to track empty loops or conditions
    protected $firstCaseSwitch = true; // Flag to track the first case in switch statements

    /**
     * Constructor to initialize the template engine with default settings
     */
    public function __construct()
    {
        // Set the file extension for template files
        $this->setFileExtension('.blade.php');

        // Set the directory where view files are stored
        $this->setViewFolder('resources/views' . DIRECTORY_SEPARATOR);

        // Set the directory where cached files are stored
        $this->setCacheFolder('storage/cache' . DIRECTORY_SEPARATOR);

        // Create the cache folder if it doesn't exist
        $this->createCacheFolder();

        // Set the format for echoing variables in templates
        $this->setEchoFormat('$this->e(%s)');

        // Initialize arrays for blocks, block stacks, and loop stacks
        $this->blocks = [];
        $this->blockStacks = [];
        $this->loopStacks = [];
    }

    /**
     * Create cache folder.
     * 
     * @return void
     */
    public function createCacheFolder(): void
    {
        if (!is_dir($this->cacheFolder)) {
            if (!mkdir($this->cacheFolder, 0755, true) && !is_dir($this->cacheFolder)) {
                throw new RuntimeException('Unable to create view cache folder: ' . $this->cacheFolder);
            }
        }
    }

    //!----------------------------------------------------------------
    //! Compilers
    //!----------------------------------------------------------------

    /**
     * Compile blade statements.
     *
     * @param string $statement
     *
     * @return string
     */
    protected function compileStatements($statement): string
    {
        $pattern = '/\B@(@?\w+(?:->\w+)?)([ \t]*)(\( ( (?>[^()]+) | (?3) )* \))?/x';

        return preg_replace_callback($pattern, function ($match) {
            // default commands
            if (method_exists($this, $method = 'compile' . ucfirst($match[1]))) {
                $match[0] = $this->{$method}(isset($match[3]) ? $match[3] : '');
            }

            // custom directives
            if (isset(self::$directives[$match[1]])) {
                if ((isset($match[3][0]) && '(' === $match[3][0])
                    && (isset($match[3][strlen($match[3]) - 1]) && ')' === $match[3][strlen($match[3]) - 1])
                ) {
                    $match[3] = substr($match[3], 1, -1);
                }

                if (isset($match[3]) && '()' !== $match[3]) {
                    $match[0] = call_user_func(self::$directives[$match[1]], trim($match[3]));
                }
            }

            return isset($match[3]) ? $match[0] : $match[0] . $match[2];
        }, $statement);
    }

    /**
     * Compile blade comments.
     *
     * @param string $comment
     *
     * @return string
     */
    protected function compileComments($comment): string
    {
        return preg_replace('/\{\{--((.|\s)*?)--\}\}/', '<?php /*$1*/ ?>', $comment);
    }

    /**
     * Compile blade echoes.
     *
     * @param string $string
     *
     * @return string
     */
    protected function compileEchos($string): string
    {
        // compile escaped echoes
        $string = preg_replace_callback('/\{\{\{\s*(.+?)\s*\}\}\}(\r?\n)?/s', function ($matches) {
            $whitespace = empty($matches[2]) ? '' : $matches[2] . $matches[2];
            return '<?php echo $this->e(' . $this->compileEchoDefaults($matches[1]) . ') ?>' . $whitespace;
        }, $string);

        // compile unescaped echoes
        $string = preg_replace_callback('/\{\!!\s*(.+?)\s*!!\}(\r?\n)?/s', function ($matches) {
            $whitespace = empty($matches[2]) ? '' : $matches[2] . $matches[2];
            return '<?php echo ' . $this->compileEchoDefaults($matches[1]) . ' ?>' . $whitespace;
        }, $string);

        // compile regular echoes
        $string = preg_replace_callback('/(@)?\{\{\s*(.+?)\s*\}\}(\r?\n)?/s', function ($matches) {
            $whitespace = empty($matches[3]) ? '' : $matches[3] . $matches[3];
            return $matches[1]
                ? substr($matches[0], 1)
                : '<?php echo '
                . sprintf($this->echoFormat, $this->compileEchoDefaults($matches[2]))
                . ' ?>' . $whitespace;
        }, $string);

        return $string;
    }

    /**
     * Compile default echoes.
     *
     * @param string $string
     *
     * @return string
     */
    public function compileEchoDefaults($string): string
    {
        return preg_replace('/^(?=\$)(.+?)(?:\s+or\s+)(.+?)$/s', 'isset($1) ? $1 : $2', $string);
    }

    /**
     * Compile user-defined extensions.
     *
     * @param string $string
     *
     * @return string
     */
    protected function compileExtensions($string): string
    {
        foreach ($this->extensions as $compiler) {
            $string = $compiler($string, $this);
        }

        return $string;
    }

    /**
     * Replace @php and @endphp blocks.
     *
     * @param string $string
     *
     * @return string
     */
    public function replacePhpBlocks($string): string
    {
        $string = preg_replace_callback('/(?<!@)@php(.*?)@endphp/s', function ($matches) {
            return "<?php{$matches[1]}?>";
        }, $string);

        return $string;
    }

    /**
     * Escape variables.
     *
     * @param string $string
     * @param string $charset
     *
     * @return string
     */
    public function e(string|array $string, $charset = null): string
    {
        if (is_array($string)) {
            $string = implode(' ', $string);
        }
        return htmlspecialchars($string, ENT_QUOTES, is_null($charset) ? 'UTF-8' : $charset);
    }

    //!----------------------------------------------------------------
    //! Concerns
    //!----------------------------------------------------------------

    /**
     * Usage: @php($varName = 'value').
     *
     * @param string $value
     *
     * @return string
     */
    protected function compilePhp($value): string
    {
        return $value ? "<?php {$value}; ?>" : "@php{$value}";
    }

    /**
     * Usage: @json($data).
     *
     * @param mixed $data
     *
     * @return string
     */
    protected function compileJson($data): string
    {
        $default = JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT;

        if (isset($data) && '(' == $data[0]) {
            $data = substr($data, 1, -1);
        }

        $parts = explode(',', $data);
        $options = isset($parts[1]) ? trim($parts[1]) : $default;
        $depth = isset($parts[2]) ? trim($parts[2]) : 512;

        // PHP < 5.5.0 doesn't have the $depth parameter
        if (PHP_VERSION_ID >= 50500) {
            return "<?php echo json_encode($parts[0], $options, $depth) ?>";
        }

        return "<?php echo json_encode($parts[0], $options) ?>";
    }

    /**
     * Usage: @unset($var).
     *
     * @param mixed $variable
     *
     * @return string
     */
    protected function compileUnset($variable): string
    {
        return "<?php unset{$variable}; ?>";
    }

    /**
     * Usage: @if ($condition).
     *
     * @param mixed $condition
     *
     * @return string
     */
    protected function compileIf($condition): string
    {
        return "<?php if{$condition}: ?>";
    }

    /**
     * Usage: @elseif (condition).
     *
     * @param mixed $condition
     *
     * @return string
     */
    protected function compileElseif($condition): string
    {
        return "<?php elseif{$condition}: ?>";
    }

    /**
     * Usage: @else.
     *
     * @return string
     */
    protected function compileElse(): string
    {
        return '<?php else: ?>';
    }

    /**
     * Usage: @endif.
     *
     * @return string
     */
    protected function compileEndif(): string
    {
        return '<?php endif; ?>';
    }

    /**
     * Usage: @switch ($condition).
     *
     * @param mixed $condition
     *
     * @return string
     */
    protected function compileSwitch($condition): string
    {
        $this->firstCaseSwitch = true;
        return "<?php switch{$condition}:";
    }

    /**
     * Usage: @case ($condition).
     *
     * @param mixed $condition
     *
     * @return string
     */
    protected function compileCase($condition): string
    {
        if ($this->firstCaseSwitch) {
            $this->firstCaseSwitch = false;
            return "case {$condition}: ?>";
        }

        return "<?php case {$condition}: ?>";
    }

    /**
     * Usage: @default.
     *
     * @return string
     */
    protected function compileDefault(): string
    {
        return '<?php default: ?>';
    }

    /**
     * Usage: @break or @break($condition).
     *
     * @param mixed $condition
     *
     * @return string
     */
    protected function compileBreak($condition): string
    {
        if ($condition) {
            preg_match('/\(\s*(-?\d+)\s*\)$/', $condition, $matches);
            return $matches
                ? '<?php break ' . max(1, $matches[1]) . '; ?>'
                : "<?php if{$condition} break; ?>";
        }

        return '<?php break; ?>';
    }

    /**
     * Usage: @endswitch.
     *
     * @return string
     */
    protected function compileEndswitch(): string
    {
        return '<?php endswitch; ?>';
    }

    /**
     * Usage: @isset($variable).
     *
     * @param mixed $variable
     *
     * @return string
     */
    protected function compileIsset($variable): string
    {
        return "<?php if (isset{$variable}): ?>";
    }

    /**
     * Usage: @endisset.
     *
     * @return string
     */
    protected function compileEndisset(): string
    {
        return '<?php endif; ?>';
    }

    /**
     * Usage: @continue or @continue($condition).
     *
     * @param mixed $condition
     *
     * @return string
     */
    protected function compileContinue($condition): string
    {
        if ($condition) {
            preg_match('/\(\s*(-?\d+)\s*\)$/', $condition, $matches);
            return $matches
                ? '<?php continue ' . max(1, $matches[1]) . '; ?>'
                : "<?php if{$condition} continue; ?>";
        }

        return '<?php continue; ?>';
    }

    /**
     * Usage: @exit or @exit($condition).
     *
     * @param mixed $condition
     *
     * @return string
     */
    protected function compileExit($condition): string
    {
        if ($condition) {
            preg_match('/\(\s*(-?\d+)\s*\)$/', $condition, $matches);
            return $matches
                ? '<?php exit ' . max(1, $matches[1]) . '; ?>'
                : "<?php if{$condition} exit; ?>";
        }
        return '<?php exit; ?>';
    }

    /**
     * Usage: @unless($condition).
     *
     * @param mixed $condition
     *
     * @return string
     */
    protected function compileUnless($condition): string
    {
        return "<?php if (! $condition): ?>";
    }

    /**
     * Usage: @endunless.
     *
     * @return string
     */
    protected function compileEndunless(): string
    {
        return '<?php endif; ?>';
    }

    /**
     * Usage: @for ($condition).
     *
     * @param mixed $condition
     *
     * @return string
     */
    protected function compileFor($condition): string
    {
        return "<?php for{$condition}: ?>";
    }

    /**
     * Usage: @endfor.
     *
     * @return string
     */
    protected function compileEndfor(): string
    {
        return '<?php endfor; ?>';
    }

    /**
     * Usage: @foreach ($expression).
     *
     * @param mixed $expression
     *
     * @return string
     */
    protected function compileForeach($expression): string
    {
        preg_match('/\( *(.*) +as *(.*)\)$/is', $expression, $matches);

        $iteratee = trim($matches[1]);
        $iteration = trim($matches[2]);
        $initLoop = "\$__currloopdata = {$iteratee}; \$this->addLoop(\$__currloopdata);";
        $iterateLoop = '$this->incrementLoopIndices(); $loop = $this->getFirstLoop();';

        return "<?php {$initLoop} foreach(\$__currloopdata as {$iteration}): {$iterateLoop} ?>";
    }

    /**
     * Usage: @endforeach.
     *
     * @return string
     */
    protected function compileEndforeach(): string
    {
        return '<?php endforeach; ?>';
    }

    /**
     * Usage: @forelse ($condition).
     *
     * @param mixed $expression
     *
     * @return string
     */
    protected function compileForelse($expression): string
    {
        preg_match('/\( *(.*) +as *(.*)\)$/is', $expression, $matches);

        $iteratee = trim($matches[1]);
        $iteration = trim($matches[2]);
        $initLoop = "\$__currloopdata = {$iteratee}; \$this->addLoop(\$__currloopdata);";
        $iterateLoop = '$this->incrementLoopIndices(); $loop = $this->getFirstLoop();';

        ++$this->emptyCounter;

        return "<?php {$initLoop} \$__empty_{$this->emptyCounter} = true;"
            . " foreach(\$__currloopdata as {$iteration}): "
            . "\$__empty_{$this->emptyCounter} = false; {$iterateLoop} ?>";
    }

    /**
     * Usage: @empty.
     *
     * @return string
     */
    protected function compileEmpty(): string
    {
        $string = "<?php endforeach; if (\$__empty_{$this->emptyCounter}): ?>";
        --$this->emptyCounter;

        return $string;
    }

    /**
     * Usage: @endforelse.
     *
     * @return string
     */
    protected function compileEndforelse(): string
    {
        return '<?php endif; ?>';
    }

    /**
     * Usage: @while ($condition).
     *
     * @param mixed $condition
     *
     * @return string
     */
    protected function compileWhile($condition): string
    {
        return "<?php while{$condition}: ?>";
    }

    /**
     * Usage: @endwhile.
     *
     * @return string
     */
    protected function compileEndwhile(): string
    {
        return '<?php endwhile; ?>';
    }

    /**
     * Usage: @extends($parent).
     *
     * @param string $parent
     *
     * @return string
     */
    protected function compileExtends($parent): string
    {
        if (isset($parent[0]) && '(' === $parent[0]) {
            $parent = substr($parent, 1, -1);
        }

        return "<?php \$this->addParent({$parent}) ?>";
    }

    /**
     * Usage: @include($view).
     *
     * @param string $view
     *
     * @return string
     */
    protected function compileInclude($view): string
    {
        if (isset($view[0]) && '(' === $view[0]) {
            $view = substr($view, 1, -1);
        }

        return "<?php include \$this->prepare({$view}) ?>";
    }

    /**
     * Usage: @yield($string).
     *
     * @param string $string
     *
     * @return string
     */
    protected function compileYield($string): string
    {
        return "<?php echo \$this->block{$string} ?>";
    }

    /**
     * Usage: @section($name).
     *
     * @param string $name
     *
     * @return string
     */
    protected function compileSection($name): string
    {
        return "<?php \$this->beginBlock{$name} ?>";
    }

    /**
     * Usage: @endsection.
     *
     * @return string
     */
    protected function compileEndsection(): string
    {
        return '<?php $this->endBlock() ?>';
    }

    /**
     * Usage: @show.
     *
     * @return string
     */
    protected function compileShow(): string
    {
        return '<?php echo $this->block($this->endBlock()) ?>';
    }

    /**
     * Usage: @append.
     *
     * @return string
     */
    protected function compileAppend(): string
    {
        return '<?php $this->endBlock() ?>';
    }

    /**
     * Usage: @stop.
     *
     * @return string
     */
    protected function compileStop(): string
    {
        return '<?php $this->endBlock() ?>';
    }

    /**
     * Usage: @overwrite.
     *
     * @return string
     */
    protected function compileOverwrite(): string
    {
        return '<?php $this->endBlock(true) ?>';
    }

    /**
     * Usage: @method('put').
     *
     * @param string $method
     *
     * @return string
     */
    protected function compileMethod($method): string
    {
        return "<input type=\"hidden\" name=\"_method\" value=\"<?php echo strtoupper{$method} ?>\">\n";
    }

    /**
     * Usage: @csrf
     *
     * Generate random string to protect spumy form submit
     *
     * @return string
     */
    protected function compileCsrf()
    {
        return "<input type=\"hidden\" name=\"csrf_token\" value=\"<?php echo bin2hex(openssl_random_pseudo_bytes(10)) ?>\">\n";
    }

    //!----------------------------------------------------------------
    //! Renderer
    //!----------------------------------------------------------------

    /**
     * Render the view template.
     * Tip: dot and forward-slash (., /) can be used as directory separator.
     *
     * @param string $name
     * @param array  $data
     * @param bool   $returnOnly
     *
     * @return string
     */
    public function render($name, array $data = [], $returnOnly = false)
    {
        $html = $this->fetch($name, $data);

        if (false !== $returnOnly) {
            return $html;
        }

        echo $html;
    }

    /**
     * Clear chache folder.
     *
     * @return bool
     */
    public function clearCache(): bool
    {
        $extension = ltrim($this->fileExtension, '.');
        $files = glob($this->cacheFolder . DIRECTORY_SEPARATOR . '*.' . $extension);
        $result = true;

        foreach ($files as $file) {
            if (is_file($file)) {
                $result = @unlink($file);
            }
        }

        return $result;
    }

    /**
     * Set file extension for the view files
     * Default to: '.blade.php'.
     *
     * @param string $extension
     */
    public function setFileExtension($extension): void
    {
        $this->fileExtension = $extension;
    }

    /**
     * Set view folder location
     * Default to: './views'.
     *
     * @param string $value
     */
    public function setViewFolder($path): void
    {
        $this->viewFolder = str_replace('/', DIRECTORY_SEPARATOR, $path);
    }

    /**
     * Set cache folder location
     * Default to: ./cache.
     *
     * @param string $path
     */
    public function setCacheFolder($path): void
    {
        $this->cacheFolder = str_replace('/', DIRECTORY_SEPARATOR, $path);
    }

    /**
     * Set echo format
     * Default to: '$this->e($data)'.
     *
     * @param string $format
     */
    public function setEchoFormat($format): void
    {
        $this->echoFormat = $format;
    }

    /**
     * Extend this class (Add custom directives).
     *
     * @param Closure $compiler
     */
    public function extend(Closure $compiler): void
    {
        $this->extensions[] = $compiler;
    }

    /**
     * Another (simpler) way to add custom directives.
     *
     * @param string $name
     * @param string $callback
     */
    public function directive($name, Closure $callback): void
    {
        if (!preg_match('/^\w+(?:->\w+)?$/x', $name)) {
            throw new InvalidArgumentException(
                'The directive name [' . $name . '] is not valid. Directive names ' .
                    'must only contains alphanumeric characters and underscores.'
            );
        }

        self::$directives[$name] = $callback;
    }

    /**
     * Get all defined directives.
     *
     * @return array
     */
    public function getAllDirectives(): array
    {
        return self::$directives;
    }

    /**
     * Prepare the view file (locate and extract).
     *
     * @param string $view
     */
    protected function prepare($view): string
    {
        $view = str_replace(['.', '/'], DIRECTORY_SEPARATOR, ltrim($view, '/'));
        $actual = $this->viewFolder . DIRECTORY_SEPARATOR . $view . $this->fileExtension;

        $view = str_replace(['/', '\\', DIRECTORY_SEPARATOR], '.', $view);
        $cache = $this->cacheFolder . DIRECTORY_SEPARATOR . $view . '__' . sprintf('%u', crc32($view)) . '.php';

        if (!is_file($cache) || filemtime($actual) > filemtime($cache)) {
            if (!is_file($actual)) {
                throw new RuntimeException('View file not found: ' . $actual);
            }

            $content = file_get_contents($actual);
            // Add @set() directive using extend() method, we need 2 parameters here
            $this->extend(function ($value) {
                return preg_replace("/@set\(['\"](.*?)['\"]\,(.*)\)/", '<?php $$1 =$2; ?>', $value);
            });

            $compilers = ['Statements', 'Comments', 'Echos', 'Extensions'];

            foreach ($compilers as $compiler) {
                $content = $this->{'compile' . $compiler}($content);
            }

            // Replace @php and @endphp blocks
            $content = $this->replacePhpBlocks($content);

            file_put_contents($cache, $content);
        }

        return $cache;
    }

    /**
     * Fetch the view data passed by user.
     *
     * @param string $view
     * @param array  $data
     */
    public function fetch($name, array $data = []): string
    {
        $this->templates[] = $name;

        if (!empty($data)) {
            extract($data);
        }

        while ($templates = array_shift($this->templates)) {
            $this->beginBlock('content');
            require $this->prepare($templates);
            $this->endBlock(true);
        }

        return $this->block('content');
    }

    /**
     * Helper method for @extends() directive to define parent view.
     *
     * @param string $name
     */
    protected function addParent($name): void
    {
        $this->templates[] = $name;
    }

    /**
     * Return content of block if exists.
     *
     * @param string $name
     * @param mixed  $default
     *
     * @return string
     */
    protected function block($name, $default = ''): string
    {
        return array_key_exists($name, $this->blocks) ? $this->blocks[$name] : $default;
    }

    /**
     * Start a block.
     *
     * @param string $name
     *
     * @return void
     */
    protected function beginBlock($name): void
    {
        array_push($this->blockStacks, $name);
        ob_start();
    }

    /**
     * Ends a block.
     *
     * @param bool $overwrite
     *
     * @return mixed
     */
    protected function endBlock($overwrite = false): mixed
    {
        $name = array_pop($this->blockStacks);

        if ($overwrite || !array_key_exists($name, $this->blocks)) {
            $this->blocks[$name] = ob_get_clean();
        } else {
            $this->blocks[$name] .= ob_get_clean();
        }

        return $name;
    }

    /**
     * Add new loop to the stack.
     *
     * @param mixed $data
     */
    public function addLoop($data): void
    {
        $length = (is_array($data) || $data instanceof Countable) ? count($data) : null;
        $parent = empty($this->loopStacks) ? null : end($this->loopStacks);
        $this->loopStacks[] = [
            'iteration' => 0,
            'index' => 0,
            'remaining' => isset($length) ? $length : null,
            'count' => $length,
            'first' => true,
            'last' => isset($length) ? ($length === 1) : null,
            'depth' => count($this->loopStacks) + 1,
            'parent' => $parent ? (object) $parent : null,
        ];
    }

    /**
     * Increment the top loop's indices.
     *
     * @return void
     */
    public function incrementLoopIndices(): void
    {
        $loop = &$this->loopStacks[count($this->loopStacks) - 1];
        $loop['iteration']++;
        $loop['index'] = $loop['iteration'] - 1;
        $loop['first'] = ((int) $loop['iteration'] === 1);

        if (isset($loop['count'])) {
            $loop['remaining']--;
            $loop['last'] = ((int) $loop['iteration'] === (int) $loop['count']);
        }
    }

    /**
     * Get an instance of the first loop in the stack.
     *
     * @return \stdClass|null
     */
    public function getFirstLoop(): \stdClass|null
    {
        return ($last = end($this->loopStacks)) ? (object) $last : null;
    }
}

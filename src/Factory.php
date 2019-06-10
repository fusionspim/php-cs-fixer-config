<?php
namespace FusionsPim\PhpCsFixer;

use PhpCsFixer\{Config, Finder};

class Factory
{
    public const DEFAULT_EXCLUDED_DIRS = ['assets', 'cache', 'node_modules']; // PhpCsFixer excludes vendor already

    public const DEFAULT_EXCLUDED_NAME = 'AcceptanceTesterActions.php'; // Annotated with @codingStandardsIgnoreFile

    // @todo Ensuring there's a space after `//` would be nice, but there's no rule for that just yet :-)
    public const DEFAULT_RULES = [
        '@PSR2'                                      => true,
        'array_indentation'                          => true,
        'array_syntax'                               => ['syntax' => 'short'],
        'binary_operator_spaces'                     => ['default' => 'align_single_space'],
        'blank_line_before_statement'                => [
            'statements' => ['case', 'for', 'foreach', 'if', 'return', 'switch', 'try', 'while'],
        ],
        'cast_spaces'                                => ['space' => 'single'],
        'combine_consecutive_issets'                 => true,
        'compact_nullable_typehint'                  => true,
        'concat_space'                               => ['spacing' => 'one'],
        'dir_constant'                               => true,
        'function_to_constant'                       => true,
        'function_typehint_space'                    => true,
        'lowercase_cast'                             => true,
        'lowercase_static_reference'                 => true,
        'magic_constant_casing'                      => true,
        'magic_method_casing'                        => true,
        'method_argument_space'                      => ['on_multiline' => 'ignore'],
        'method_chaining_indentation'                => true,
        'mb_str_functions'                           => true,
        'no_blank_lines_after_class_opening'         => true,
        'no_break_comment'                           => false,
        'no_extra_blank_lines'                       => ['tokens' => ['extra']],
        'no_mixed_echo_print'                        => ['use' => 'echo'],
        'no_singleline_whitespace_before_semicolons' => true,
        'no_superfluous_phpdoc_tags'                 => true,
        'no_trailing_comma_in_singleline_array'      => true,
        'no_unneeded_control_parentheses'            => [ // We occasionally use around `return`
            'statements' => ['break', 'clone', 'continue', 'echo_print', 'switch_case', 'yield'],
        ],
        'no_unused_imports'                          => true,
        'no_useless_else'                            => true,
        'no_useless_return'                          => true,
        'no_whitespace_before_comma_in_array'        => true,
        'no_whitespace_in_blank_line'                => true,
        'normalize_index_brace'                      => true,
        'not_operator_with_successor_space'          => true,
        'ordered_class_elements'                     => [ // Default, except we don't order methods for now
            'use_trait',
            'constant_public',
            'constant_protected',
            'constant_private',
            'property_public',
            'property_protected',
            'property_private',
            'construct',
            'destruct',
            'magic',
            'phpunit',
        ],
        'ordered_imports'                            => [
            'importsOrder'  => ['class', 'function', 'const'],
            'sortAlgorithm' => 'alpha',
        ],
        'php_unit_construct'                         => true,
        'php_unit_method_casing'                     => ['case' => 'snake_case'],
        'php_unit_set_up_tear_down_visibility'       => true,
        'php_unit_strict'                            => true,
        'php_unit_no_expectation_annotation'         => true,
        'php_unit_expectation'                       => true,
        'return_type_declaration'                    => true,
        'single_import_per_statement'                => false,
        'single_line_comment_style'                  => true,
        'standardize_not_equals'                     => true,
        'ternary_operator_spaces'                    => true,
        'ternary_to_null_coalescing'                 => true,
        'trailing_comma_in_multiline_array'          => true,
        'trim_array_spaces'                          => true,
        'unary_operator_spaces'                      => true,
        'void_return'                                => true,
        'whitespace_after_comma_in_array'            => true,
        'yoda_style'                                 => false,
    ];

    public static function fromDefaults(array $overrideRules = []): Config
    {
        $finder = Finder::create()
            ->in(getcwd())
            ->exclude(static::DEFAULT_EXCLUDED_DIRS)
            ->notName(static::DEFAULT_EXCLUDED_NAME)
            ->name('*.phtml'); // PhpCsFixer adds *.php and *.phpt already

        return Config::create()
            ->setRiskyAllowed(true)
            ->setRules(\array_merge(static::DEFAULT_RULES, $overrideRules))
            ->setUsingCache(true)
            ->setFinder($finder);
    }
}

<?php
namespace FusionsPim\PhpCsFixer;

use PhpCsFixer\{Config, Finder};
use PhpCsFixerCustomFixers\Fixer\{CommentSurroundedBySpacesFixer, CommentedOutFunctionFixer, DataProviderNameFixer, DataProviderReturnTypeFixer, InternalClassCasingFixer, NoCommentedOutCodeFixer, NoDoctrineMigrationsGeneratedCommentFixer, NoDuplicatedArrayKeyFixer, NoDuplicatedImportsFixer, NoPhpStormGeneratedCommentFixer, NoSuperfluousConcatenationFixer, NoUselessCommentFixer, NoUselessDoctrineRepositoryCommentFixer, NoUselessSprintfFixer, PhpUnitNoUselessReturnFixer, PhpdocNoIncorrectVarAnnotationFixer, PhpdocSingleLineVarFixer, SingleSpaceAfterStatementFixer, SingleSpaceBeforeStatementFixer};
use PhpCsFixerCustomFixers\Fixers;

class Factory
{
    public const DEFAULT_EXCLUDED_DIRS = ['assets', 'cache', 'node_modules']; // PhpCsFixer excludes vendor already

    public const DEFAULT_EXCLUDED_NAME = 'AcceptanceTesterActions.php'; // Annotated with @codingStandardsIgnoreFile

    // @todo: Use https://mlocati.github.io/php-cs-fixer-configurator/#version:2.15|configurator and find gaps to plug
    // @todo: Adopt the '@PhpCsFixer' preset (as the second rule), then remove inherited rules unless we differ
    public const DEFAULT_RULES = [
        '@PSR2'                                      => true,
        'align_multiline_comment'                    => true,
        'array_indentation'                          => true,
        'array_syntax'                               => ['syntax' => 'short'],
        'backtick_to_shell_exec'                     => true,
        'binary_operator_spaces'                     => ['default' => 'align_single_space'],
        'blank_line_after_opening_tag'               => false, // We prefer the opposite to @PhpCsFixer
        'blank_line_before_statement'                => [
            'statements' => ['case', 'for', 'foreach', 'if', 'return', 'switch', 'try', 'while'],
        ],
        'cast_spaces'                                => ['space' => 'single'],
        'class_attributes_separation'                => ['elements' => ['method']], // We like to group const/property
        'class_keyword_remove'                       => false, // We like IDEs picking up usage via ::class
        'combine_consecutive_issets'                 => true,
        'combine_consecutive_unsets'                 => true,
        'combine_nested_dirname'                     => true,
        'compact_nullable_typehint'                  => true,
        'concat_space'                               => ['spacing' => 'one'],
        'date_time_immutable'                        => true,
        'declare_equal_normalize'                    => true,
        'declare_strict_types'                       => false,
        'dir_constant'                               => true,
        'ereg_to_preg'                               => true,
        'error_suppression'                          => true,
        'explicit_indirect_variable'                 => true,
        'explicit_string_variable'                   => true,
        'fully_qualified_strict_types'               => true,
        'function_to_constant'                       => true,
        'function_typehint_space'                    => true,
        'general_phpdoc_annotation_remove'           => ['annotations' => []],
        'heredoc_indentation'                        => false, // Too many changes for now
        'heredoc_to_nowdoc'                          => false, // Too many changes for now
        'implode_call'                               => true,
        'include'                                    => true,
        'linebreak_after_opening_tag'                => true,
        'logical_operators'                          => true,
        'lowercase_cast'                             => true,
        'lowercase_static_reference'                 => true,
        'magic_constant_casing'                      => true,
        'magic_method_casing'                        => true,
        'method_argument_space'                      => ['on_multiline' => 'ignore'],
        'method_chaining_indentation'                => true,
        'mb_str_functions'                           => true,
        'modernize_types_casting'                    => true,
        'multiline_comment_opening_closing'          => true,
        'multiline_whitespace_before_semicolons'     => true,
        'native_function_casing'                     => true,
        'new_with_braces'                            => false, // We prefer the opposite to @PhpCsFixer
        'no_alias_functions'                         => true,
        'no_alternative_syntax'                      => true,
        'no_binary_string'                           => true,
        'no_blank_lines_after_class_opening'         => true,
        'no_blank_lines_before_namespace'            => true,
        'no_break_comment'                           => false, // We prefer the opposite to @PSR2 and @PhpCsFixer
        'no_empty_comment'                           => true,
        'no_empty_phpdoc'                            => true,
        'no_empty_statement'                         => true,
        'no_extra_blank_lines'                       => ['tokens' => ['extra']],
        'no_homoglyph_names'                         => true,
        'no_leading_import_slash'                    => true,
        'no_leading_namespace_whitespace'            => true,
        'no_mixed_echo_print'                        => ['use' => 'echo'],
        'no_php4_constructor'                        => true,
        'no_short_bool_cast'                         => true,
        'no_short_echo_tag'                          => false, // We prefer the opposite to @PhpCsFixer
        'no_singleline_whitespace_before_semicolons' => true,
        'no_spaces_around_offset'                    => true,
        'no_superfluous_elseif'                      => true,
        'no_superfluous_phpdoc_tags'                 => true,
        'no_trailing_comma_in_list_call'             => true,
        'no_trailing_comma_in_singleline_array'      => true,
        'no_unneeded_control_parentheses'            => [ // We occasionally use around `return`
            'statements' => ['break', 'clone', 'continue', 'echo_print', 'switch_case', 'yield'],
        ],
        'no_unneeded_curly_braces'                   => true,
        'no_unset_cast'                              => true,
        'no_unreachable_default_argument_value'      => true,
        'no_unused_imports'                          => true,
        'no_useless_else'                            => true,
        'no_useless_return'                          => true,
        'no_whitespace_before_comma_in_array'        => true,
        'no_whitespace_in_blank_line'                => true,
        'non_printable_character'                    => false, // We have these in tests
        'normalize_index_brace'                      => true,
        'not_operator_with_successor_space'          => true,
        'object_operator_without_whitespace'         => true,
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
        'php_unit_dedicate_assert'                   => true,
        'php_unit_dedicate_assert_internal_type'     => true,
        'php_unit_expectation'                       => true,
        'php_unit_method_casing'                     => ['case' => 'snake_case'],
        'php_unit_namespaced'                        => true,
        'php_unit_no_expectation_annotation'         => true,
        'php_unit_set_up_tear_down_visibility'       => true,
        'php_unit_strict'                            => true,
        'php_unit_test_annotation'                   => true,
        'psr4'                                       => true,
        'random_api_migration'                       => true,
        'return_assignment'                          => true,
        'return_type_declaration'                    => true,
        'self_accessor'                              => true,
        'semicolon_after_instruction'                => true,
        'set_type_to_cast'                           => true,
        'short_scalar_cast'                          => true,
        'simple_to_complex_string_variable'          => true,
        'simplified_null_return'                     => true,
        'single_blank_line_before_namespace'         => false, // We prefer no_blank_lines_before_namespace
        'single_import_per_statement'                => false, // We like import grouping within the same namespace
        'single_line_comment_style'                  => true,
        'space_after_semicolon'                      => true,
        'standardize_increment'                      => true,
        'standardize_not_equals'                     => true,
        'strict_comparison'                          => true,
        'ternary_operator_spaces'                    => true,
        'ternary_to_null_coalescing'                 => true,
        'trailing_comma_in_multiline_array'          => true,
        'trim_array_spaces'                          => true,
        'unary_operator_spaces'                      => true,
        'void_return'                                => true,
        'whitespace_after_comma_in_array'            => true,
        'yoda_style'                                 => false, // We prefer the opposite to @PhpCsFixer
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
            ->registerCustomFixers(new Fixers)
            ->setRules(\array_merge(static::DEFAULT_RULES, self::extraRules(), $overrideRules))
            ->setUsingCache(true)
            ->setFinder($finder);
    }

    // Hopefully these'll be merged into PHP CS Fixer? https://github.com/kubawerlos/php-cs-fixer-custom-fixers/issues/128
    private static function extraRules(): array
    {
        return [
            CommentedOutFunctionFixer::name()                 => ['print_r', 'var_dump', 'var_export'],
            CommentSurroundedBySpacesFixer::name()            => true, // @see https://github.com/FriendsOfPHP/PHP-CS-Fixer/issues/4480
            DataProviderNameFixer::name()                     => ['suffix' => '_data_provider'],
            DataProviderReturnTypeFixer::name()               => true,
            InternalClassCasingFixer::name()                  => true,
            NoCommentedOutCodeFixer::name()                   => true,
            NoDoctrineMigrationsGeneratedCommentFixer::name() => true,
            NoDuplicatedArrayKeyFixer::name()                 => true,
            NoDuplicatedImportsFixer::name()                  => true,
            NoPhpStormGeneratedCommentFixer::name()           => true,
            NoSuperfluousConcatenationFixer::name()           => true, // @see https://github.com/FriendsOfPHP/PHP-CS-Fixer/issues/4491
            NoUselessCommentFixer::name()                     => true,
            NoUselessDoctrineRepositoryCommentFixer::name()   => true,
            NoUselessSprintfFixer::name()                     => true,
            PhpUnitNoUselessReturnFixer::name()               => true,
            PhpdocNoIncorrectVarAnnotationFixer::name()       => true,
            PhpdocSingleLineVarFixer::name()                  => true,
            SingleSpaceAfterStatementFixer::name()            => true,
            SingleSpaceBeforeStatementFixer::name()           => true,
        ];
    }
}

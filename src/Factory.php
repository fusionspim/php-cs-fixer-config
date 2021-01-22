<?php
namespace FusionsPim\PhpCsFixer;

use PhpCsFixer\{Config, Finder};
use PhpCsFixerCustomFixers\Fixer\{CommentSurroundedBySpacesFixer, CommentedOutFunctionFixer, DataProviderNameFixer, DataProviderReturnTypeFixer, InternalClassCasingFixer, NoCommentedOutCodeFixer, NoDoctrineMigrationsGeneratedCommentFixer, NoDuplicatedArrayKeyFixer, NoDuplicatedImportsFixer, NoPhpStormGeneratedCommentFixer, NoSuperfluousConcatenationFixer, NoUselessCommentFixer, NoUselessDoctrineRepositoryCommentFixer, NoUselessParenthesisFixer, NoUselessSprintfFixer, NoUselessStrlenFixer, PhpUnitNoUselessReturnFixer, PhpdocNoIncorrectVarAnnotationFixer, PhpdocSingleLineVarFixer, SingleSpaceAfterStatementFixer, SingleSpaceBeforeStatementFixer};
use PhpCsFixerCustomFixers\Fixers;

class Factory
{
    public const DEFAULT_EXCLUDED_DIRS = ['assets', 'cache', 'node_modules']; // PhpCsFixer excludes vendor already

    public const DEFAULT_EXCLUDED_NAME = 'AcceptanceTesterActions.php'; // Annotated with @codingStandardsIgnoreFile

    public const DEFAULT_RULES = [ // We don't have '@PhpCsFixer:risky' enabled as we don't want the native/final rules or no_unset
        '@PSR2'                                       => true,
        '@PhpCsFixer'                                 => true,
        '@PHPUnit75Migration:risky'                   => true,
        '@PHP71Migration:risky'                       => true,
        '@PHP73Migration'                             => true,
        'array_syntax'                                => ['syntax' => 'short'],
        'backtick_to_shell_exec'                      => true,
        'binary_operator_spaces'                      => ['default' => 'align_single_space'],
        'blank_line_after_opening_tag'                => false, // We prefer the opposite to @PhpCsFixer
        'blank_line_before_statement'                 => ['statements' => ['case', 'for', 'foreach', 'if', 'return', 'switch', 'try', 'while']],
        'class_attributes_separation'                 => ['elements' => ['method']], // We like to group const/property
        'class_keyword_remove'                        => false, // We like IDEs picking up usage via ::class
        'comment_to_phpdoc'                           => true,
        'concat_space'                                => ['spacing' => 'one'], // Default is 'none'
        'date_time_immutable'                         => true,
        'declare_strict_types'                        => false,
        'dir_constant'                                => true,
        'echo_tag_syntax'                             => ['format' => 'short'],
        'ereg_to_preg'                                => true,
        'error_suppression'                           => true,
        'fopen_flag_order'                            => true,
        'fopen_flags'                                 => true,
        'function_to_constant'                        => true,
        'general_phpdoc_annotation_remove'            => ['annotations' => []],
        'implode_call'                                => true,
        'increment_style'                             => false, // Sometimes either is appropriate
        'is_null'                                     => ['use_yoda_style' => false],
        'linebreak_after_opening_tag'                 => true,
        'list_syntax'                                 => ['syntax' => 'short'],
        'logical_operators'                           => true,
        'method_argument_space'                       => ['on_multiline' => 'ignore'],
        'mb_str_functions'                            => true,
        'modernize_types_casting'                     => true,
        'multiline_whitespace_before_semicolons'      => ['strategy' => 'no_multi_line'], // Supposedly the default, but doesn't behave as such?
        'new_with_braces'                             => false, // We prefer the opposite to @PhpCsFixer
        'no_alias_functions'                          => true,
        'no_blank_lines_before_namespace'             => true,
        'no_break_comment'                            => false, // We prefer the opposite to @PSR2 and @PhpCsFixer
        'no_homoglyph_names'                          => true,
        'no_php4_constructor'                         => true,
        'no_short_echo_tag'                           => false, // We prefer the opposite to @PhpCsFixer
        'no_unneeded_control_parentheses'             => [ // We occasionally use around `return`
            'statements' => ['break', 'clone', 'continue', 'echo_print', 'switch_case', 'yield'],
        ],
        'no_unneeded_final_method'                    => true,
        'no_unreachable_default_argument_value'       => true,
        'non_printable_character'                     => false, // We have these in tests
        'not_operator_with_space'                     => false, // Conflicts with not_operator_with_successor_space
        'not_operator_with_successor_space'           => true,
        'ordered_class_elements'                      => [ // Default, except we don't order methods (preferring to group related class methods, divided by large comment banners/headings)
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
        'ordered_imports'                             => ['importsOrder' => ['class', 'function', 'const'], 'sortAlgorithm' => 'alpha'],
        'ordered_interfaces'                          => true,
        'php_unit_construct'                          => true,
        'php_unit_internal_class'                     => false, // We prefer the opposite to @PhpCsFixer
        'php_unit_method_casing'                      => ['case' => 'snake_case'],
        'php_unit_mock_short_will_return'             => true,
        'php_unit_set_up_tear_down_visibility'        => true,
        'php_unit_size_class'                         => false, // We don't care about this
        'php_unit_strict'                             => true,
        'php_unit_test_annotation'                    => true,
        'php_unit_test_class_requires_covers'         => false, // We prefer the opposite to @PhpCsFixer
        'phpdoc_summary'                              => false, // We prefer the opposite to @PhpCsFixer
        'phpdoc_to_param_type'                        => true,
        'phpdoc_to_return_type'                       => true,
        'protected_to_private'                        => false,
        'psr4'                                        => true,
        'self_accessor'                               => true,
        'self_static_accessor'                        => true,
        'set_type_to_cast'                            => true,
        'simplified_null_return'                      => true,
        'single_blank_line_before_namespace'          => false, // We prefer no_blank_lines_before_namespace
        'single_import_per_statement'                 => false, // We like import grouping within the same namespace
        'single_line_throw'                           => false, // General soft line lengths cover this
        'single_trait_insert_per_statement'           => false, // We like grouping traits in one statement
        'strict_comparison'                           => true,
        'yoda_style'                                  => false, // We prefer the opposite to @PhpCsFixer
    ];

    public static function fromDefaults(array $overrideRules = []): Config
    {
        $finder = Finder::create()
            ->in(getcwd())
            ->exclude(static::DEFAULT_EXCLUDED_DIRS)
            ->notName(static::DEFAULT_EXCLUDED_NAME)
            ->name('*.phtml') // PhpCsFixer adds *.php and *.phpt already
            ->name('.php_cs.dist'); // @todo: has no effect since Finder ignores hidden files

        return Config::create()
            ->setRiskyAllowed(true)
            ->registerCustomFixers(new Fixers)
            ->setRules(\array_replace(static::DEFAULT_RULES, self::extraRules(), $overrideRules))
            ->setUsingCache(true)
            ->setFinder($finder);
    }

    // Hopefully these'll be merged into PHP CS Fixer? https://github.com/kubawerlos/php-cs-fixer-custom-fixers/issues/128
    private static function extraRules(): array
    {
        return [
            CommentedOutFunctionFixer::name()                 => ['print_r', 'var_dump', 'var_export'],
            CommentSurroundedBySpacesFixer::name()            => true, // @see https://github.com/FriendsOfPHP/PHP-CS-Fixer/issues/4480
            DataProviderNameFixer::name()                     => ['prefix' => '', 'suffix' => '_data_provider'],
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
            // NoUselessParenthesisFixer::name()                 => true, // Too many changes (we love a parenthesis!)
            NoUselessSprintfFixer::name()                     => true,
            NoUselessStrlenFixer::name()                      => true,
            PhpUnitNoUselessReturnFixer::name()               => true,
            PhpdocNoIncorrectVarAnnotationFixer::name()       => true,
            PhpdocSingleLineVarFixer::name()                  => true,
            SingleSpaceAfterStatementFixer::name()            => true,
            SingleSpaceBeforeStatementFixer::name()           => true,
        ];
    }
}

.
├── CHANGELOG.md
├── Examples
│   ├── 01_basic_template_rendering.php
│   ├── 02_component_usage.php
│   ├── 03_plugin_usage.php
│   ├── 04_htmx_integration.php
│   ├── 05_caching_and_profiling.php
│   ├── 06_plugin_conflict_resolution.php
│   ├── components
│   │   ├── CustomSearchComponent.php
│   │   └── InfiniteScrollListComponent.php
│   ├── custom_components_example.php
│   ├── htmx_advanced_example.php
│   ├── htmx_advanced_features.php
│   ├── htmx_basic_example.php
│   ├── htmx_complex_example.php
│   ├── htmx_live_search.php
│   ├── index.php
│   ├── markdown_plugin_example.php
│   ├── plugins
│   │   └── MarkdownPlugin.php
│   └── templates
│       ├── custom_components_example.html
│       ├── htmx_advanced_example.html
│       ├── htmx_advanced_features.html
│       ├── htmx_complex_example.html
│       ├── htmx_live_search.html
│       └── markdown_plugin_example.html
├── LICENSE.md
├── README.md
├── composer.json
├── composer.lock
├── docs
│   ├── component_and_htmx_examples.md
│   ├── comprehensive_guide.md
│   ├── htmx_integration.md
│   ├── htmx_integration_plan.md
│   ├── htmx_reference.md
│   ├── htmx_user_guide.md
│   └── usage.md
├── phpstack-template-system.php
├── phpstan.neon
├── phpunit.xml
├── public
│   └── js
│       └── htmx-api.js
├── src
│   └── Core
│       ├── Cache
│       │   └── FileCacheManager.php
│       ├── Exceptions
│       │   ├── ErrorHandler.php
│       │   └── PluginConflictException.php
│       ├── FileSystem
│       │   └── AsyncFilemanager.php
│       ├── Plugins
│       │   ├── HtmxPluginManager.php
│       │   ├── PluginInterface.php
│       │   ├── PluginManager.php
│       │   └── PluginSandbox.php
│       ├── Security
│       │   └── SandboxSecurityPolicy.php
│       └── Template
│           ├── BuildSystem.php
│           ├── CacheManager.php
│           ├── ComponentCache.php
│           ├── ComponentDesigner.php
│           ├── ComponentLibrary.php
│           ├── ComponentLibraryInterface.php
│           ├── Components.php
│           ├── DebugManager.php
│           ├── DistributedCache.php
│           ├── HtmxComponent.php
│           ├── HtmxComponents.php
│           ├── HtmxConfig.php
│           ├── HtmxRequestHandler.php
│           ├── HtmxResponseHandler.php
│           ├── HtmxViewHelper.php
│           ├── LazyLoadedComponent.php
│           ├── PerformanceProfiler.php
│           ├── PluginInterface.php
│           ├── PluginSandbox.php
│           ├── Plugins
│           │   ├── ComponentPlugin.php
│           │   ├── FilterPlugin.php
│           │   ├── ForPlugin.php
│           │   ├── IfPlugin.php
│           │   ├── IncludePlugin.php
│           │   ├── RenderPlugin.php
│           │   ├── SortPlugin.php
│           │   └── UserPlugins
│           │       ├── MarkdownPlugin.php
│           │       └── index.php
│           ├── TemplateEngine.php
│           ├── TemplateParser.php
│           └── TemplateRenderer.php
├── structure.md
├── tests
│   ├── HtmxAdvancedFeaturesTest.php
│   ├── HtmxCompatibilityTest.php
│   ├── HtmxComponentsTest.php
│   ├── Integration
│   │   └── TemplateSystemIntegrationTest.php
│   └── Unit
│       └── Core
│           ├── Plugins
│           │   └── PluginManagerTest.php
│           └── Template
│               ├── HtmxComponentsTest.php
│               ├── HtmxRequestHandlerTest.php
│               └── TemplateEngineTest.php
└── vendor
    ├── autoload.php
    ├── bin
    │   ├── php-parse
    │   ├── php-parse.bat
    │   ├── phpstan
    │   ├── phpstan.bat
    │   ├── phpstan.phar
    │   ├── phpstan.phar.bat
    │   ├── phpunit
    │   └── phpunit.bat
    ├── composer
    │   ├── ClassLoader.php
    │   ├── InstalledVersions.php
    │   ├── LICENSE
    │   ├── autoload_classmap.php
    │   ├── autoload_files.php
    │   ├── autoload_namespaces.php
    │   ├── autoload_psr4.php
    │   ├── autoload_real.php
    │   ├── autoload_static.php
    │   ├── installed.json
    │   ├── installed.php
    │   └── platform_check.php
    ├── doctrine
    │   └── instantiator
    │       ├── CONTRIBUTING.md
    │       ├── LICENSE
    │       ├── README.md
    │       ├── composer.json
    │       ├── docs
    │       │   └── en
    │       │       ├── index.rst
    │       │       └── sidebar.rst
    │       ├── psalm.xml
    │       └── src
    │           └── Doctrine
    │               └── Instantiator
    │                   ├── Exception
    │                   │   ├── ExceptionInterface.php
    │                   │   ├── InvalidArgumentException.php
    │                   │   └── UnexpectedValueException.php
    │                   ├── Instantiator.php
    │                   └── InstantiatorInterface.php
    ├── myclabs
    │   └── deep-copy
    │       ├── LICENSE
    │       ├── README.md
    │       ├── composer.json
    │       └── src
    │           └── DeepCopy
    │               ├── DeepCopy.php
    │               ├── Exception
    │               │   ├── CloneException.php
    │               │   └── PropertyException.php
    │               ├── Filter
    │               │   ├── ChainableFilter.php
    │               │   ├── Doctrine
    │               │   │   ├── DoctrineCollectionFilter.php
    │               │   │   ├── DoctrineEmptyCollectionFilter.php
    │               │   │   └── DoctrineProxyFilter.php
    │               │   ├── Filter.php
    │               │   ├── KeepFilter.php
    │               │   ├── ReplaceFilter.php
    │               │   └── SetNullFilter.php
    │               ├── Matcher
    │               │   ├── Doctrine
    │               │   │   └── DoctrineProxyMatcher.php
    │               │   ├── Matcher.php
    │               │   ├── PropertyMatcher.php
    │               │   ├── PropertyNameMatcher.php
    │               │   └── PropertyTypeMatcher.php
    │               ├── Reflection
    │               │   └── ReflectionHelper.php
    │               ├── TypeFilter
    │               │   ├── Date
    │               │   │   └── DateIntervalFilter.php
    │               │   ├── ReplaceFilter.php
    │               │   ├── ShallowCopyFilter.php
    │               │   ├── Spl
    │               │   │   ├── ArrayObjectFilter.php
    │               │   │   ├── SplDoublyLinkedList.php
    │               │   │   └── SplDoublyLinkedListFilter.php
    │               │   └── TypeFilter.php
    │               ├── TypeMatcher
    │               │   └── TypeMatcher.php
    │               └── deep_copy.php
    ├── nikic
    │   └── php-parser
    │       ├── LICENSE
    │       ├── README.md
    │       ├── bin
    │       │   └── php-parse
    │       ├── composer.json
    │       └── lib
    │           └── PhpParser
    │               ├── Builder
    │               │   ├── ClassConst.php
    │               │   ├── Class_.php
    │               │   ├── Declaration.php
    │               │   ├── EnumCase.php
    │               │   ├── Enum_.php
    │               │   ├── FunctionLike.php
    │               │   ├── Function_.php
    │               │   ├── Interface_.php
    │               │   ├── Method.php
    │               │   ├── Namespace_.php
    │               │   ├── Param.php
    │               │   ├── Property.php
    │               │   ├── TraitUse.php
    │               │   ├── TraitUseAdaptation.php
    │               │   ├── Trait_.php
    │               │   └── Use_.php
    │               ├── Builder.php
    │               ├── BuilderFactory.php
    │               ├── BuilderHelpers.php
    │               ├── Comment
    │               │   └── Doc.php
    │               ├── Comment.php
    │               ├── ConstExprEvaluationException.php
    │               ├── ConstExprEvaluator.php
    │               ├── Error.php
    │               ├── ErrorHandler
    │               │   ├── Collecting.php
    │               │   └── Throwing.php
    │               ├── ErrorHandler.php
    │               ├── Internal
    │               │   ├── DiffElem.php
    │               │   ├── Differ.php
    │               │   ├── PrintableNewAnonClassNode.php
    │               │   ├── TokenPolyfill.php
    │               │   └── TokenStream.php
    │               ├── JsonDecoder.php
    │               ├── Lexer
    │               │   ├── Emulative.php
    │               │   └── TokenEmulator
    │               │       ├── AttributeEmulator.php
    │               │       ├── EnumTokenEmulator.php
    │               │       ├── ExplicitOctalEmulator.php
    │               │       ├── KeywordEmulator.php
    │               │       ├── MatchTokenEmulator.php
    │               │       ├── NullsafeTokenEmulator.php
    │               │       ├── ReadonlyFunctionTokenEmulator.php
    │               │       ├── ReadonlyTokenEmulator.php
    │               │       ├── ReverseEmulator.php
    │               │       └── TokenEmulator.php
    │               ├── Lexer.php
    │               ├── Modifiers.php
    │               ├── NameContext.php
    │               ├── Node
    │               │   ├── Arg.php
    │               │   ├── ArrayItem.php
    │               │   ├── Attribute.php
    │               │   ├── AttributeGroup.php
    │               │   ├── ClosureUse.php
    │               │   ├── ComplexType.php
    │               │   ├── Const_.php
    │               │   ├── DeclareItem.php
    │               │   ├── Expr
    │               │   │   ├── ArrayDimFetch.php
    │               │   │   ├── ArrayItem.php
    │               │   │   ├── Array_.php
    │               │   │   ├── ArrowFunction.php
    │               │   │   ├── Assign.php
    │               │   │   ├── AssignOp
    │               │   │   │   ├── BitwiseAnd.php
    │               │   │   │   ├── BitwiseOr.php
    │               │   │   │   ├── BitwiseXor.php
    │               │   │   │   ├── Coalesce.php
    │               │   │   │   ├── Concat.php
    │               │   │   │   ├── Div.php
    │               │   │   │   ├── Minus.php
    │               │   │   │   ├── Mod.php
    │               │   │   │   ├── Mul.php
    │               │   │   │   ├── Plus.php
    │               │   │   │   ├── Pow.php
    │               │   │   │   ├── ShiftLeft.php
    │               │   │   │   └── ShiftRight.php
    │               │   │   ├── AssignOp.php
    │               │   │   ├── AssignRef.php
    │               │   │   ├── BinaryOp
    │               │   │   │   ├── BitwiseAnd.php
    │               │   │   │   ├── BitwiseOr.php
    │               │   │   │   ├── BitwiseXor.php
    │               │   │   │   ├── BooleanAnd.php
    │               │   │   │   ├── BooleanOr.php
    │               │   │   │   ├── Coalesce.php
    │               │   │   │   ├── Concat.php
    │               │   │   │   ├── Div.php
    │               │   │   │   ├── Equal.php
    │               │   │   │   ├── Greater.php
    │               │   │   │   ├── GreaterOrEqual.php
    │               │   │   │   ├── Identical.php
    │               │   │   │   ├── LogicalAnd.php
    │               │   │   │   ├── LogicalOr.php
    │               │   │   │   ├── LogicalXor.php
    │               │   │   │   ├── Minus.php
    │               │   │   │   ├── Mod.php
    │               │   │   │   ├── Mul.php
    │               │   │   │   ├── NotEqual.php
    │               │   │   │   ├── NotIdentical.php
    │               │   │   │   ├── Plus.php
    │               │   │   │   ├── Pow.php
    │               │   │   │   ├── ShiftLeft.php
    │               │   │   │   ├── ShiftRight.php
    │               │   │   │   ├── Smaller.php
    │               │   │   │   ├── SmallerOrEqual.php
    │               │   │   │   └── Spaceship.php
    │               │   │   ├── BinaryOp.php
    │               │   │   ├── BitwiseNot.php
    │               │   │   ├── BooleanNot.php
    │               │   │   ├── CallLike.php
    │               │   │   ├── Cast
    │               │   │   │   ├── Array_.php
    │               │   │   │   ├── Bool_.php
    │               │   │   │   ├── Double.php
    │               │   │   │   ├── Int_.php
    │               │   │   │   ├── Object_.php
    │               │   │   │   ├── String_.php
    │               │   │   │   └── Unset_.php
    │               │   │   ├── Cast.php
    │               │   │   ├── ClassConstFetch.php
    │               │   │   ├── Clone_.php
    │               │   │   ├── Closure.php
    │               │   │   ├── ClosureUse.php
    │               │   │   ├── ConstFetch.php
    │               │   │   ├── Empty_.php
    │               │   │   ├── Error.php
    │               │   │   ├── ErrorSuppress.php
    │               │   │   ├── Eval_.php
    │               │   │   ├── Exit_.php
    │               │   │   ├── FuncCall.php
    │               │   │   ├── Include_.php
    │               │   │   ├── Instanceof_.php
    │               │   │   ├── Isset_.php
    │               │   │   ├── List_.php
    │               │   │   ├── Match_.php
    │               │   │   ├── MethodCall.php
    │               │   │   ├── New_.php
    │               │   │   ├── NullsafeMethodCall.php
    │               │   │   ├── NullsafePropertyFetch.php
    │               │   │   ├── PostDec.php
    │               │   │   ├── PostInc.php
    │               │   │   ├── PreDec.php
    │               │   │   ├── PreInc.php
    │               │   │   ├── Print_.php
    │               │   │   ├── PropertyFetch.php
    │               │   │   ├── ShellExec.php
    │               │   │   ├── StaticCall.php
    │               │   │   ├── StaticPropertyFetch.php
    │               │   │   ├── Ternary.php
    │               │   │   ├── Throw_.php
    │               │   │   ├── UnaryMinus.php
    │               │   │   ├── UnaryPlus.php
    │               │   │   ├── Variable.php
    │               │   │   ├── YieldFrom.php
    │               │   │   └── Yield_.php
    │               │   ├── Expr.php
    │               │   ├── FunctionLike.php
    │               │   ├── Identifier.php
    │               │   ├── InterpolatedStringPart.php
    │               │   ├── IntersectionType.php
    │               │   ├── MatchArm.php
    │               │   ├── Name
    │               │   │   ├── FullyQualified.php
    │               │   │   └── Relative.php
    │               │   ├── Name.php
    │               │   ├── NullableType.php
    │               │   ├── Param.php
    │               │   ├── PropertyItem.php
    │               │   ├── Scalar
    │               │   │   ├── DNumber.php
    │               │   │   ├── Encapsed.php
    │               │   │   ├── EncapsedStringPart.php
    │               │   │   ├── Float_.php
    │               │   │   ├── Int_.php
    │               │   │   ├── InterpolatedString.php
    │               │   │   ├── LNumber.php
    │               │   │   ├── MagicConst
    │               │   │   │   ├── Class_.php
    │               │   │   │   ├── Dir.php
    │               │   │   │   ├── File.php
    │               │   │   │   ├── Function_.php
    │               │   │   │   ├── Line.php
    │               │   │   │   ├── Method.php
    │               │   │   │   ├── Namespace_.php
    │               │   │   │   └── Trait_.php
    │               │   │   ├── MagicConst.php
    │               │   │   └── String_.php
    │               │   ├── Scalar.php
    │               │   ├── StaticVar.php
    │               │   ├── Stmt
    │               │   │   ├── Block.php
    │               │   │   ├── Break_.php
    │               │   │   ├── Case_.php
    │               │   │   ├── Catch_.php
    │               │   │   ├── ClassConst.php
    │               │   │   ├── ClassLike.php
    │               │   │   ├── ClassMethod.php
    │               │   │   ├── Class_.php
    │               │   │   ├── Const_.php
    │               │   │   ├── Continue_.php
    │               │   │   ├── DeclareDeclare.php
    │               │   │   ├── Declare_.php
    │               │   │   ├── Do_.php
    │               │   │   ├── Echo_.php
    │               │   │   ├── ElseIf_.php
    │               │   │   ├── Else_.php
    │               │   │   ├── EnumCase.php
    │               │   │   ├── Enum_.php
    │               │   │   ├── Expression.php
    │               │   │   ├── Finally_.php
    │               │   │   ├── For_.php
    │               │   │   ├── Foreach_.php
    │               │   │   ├── Function_.php
    │               │   │   ├── Global_.php
    │               │   │   ├── Goto_.php
    │               │   │   ├── GroupUse.php
    │               │   │   ├── HaltCompiler.php
    │               │   │   ├── If_.php
    │               │   │   ├── InlineHTML.php
    │               │   │   ├── Interface_.php
    │               │   │   ├── Label.php
    │               │   │   ├── Namespace_.php
    │               │   │   ├── Nop.php
    │               │   │   ├── Property.php
    │               │   │   ├── PropertyProperty.php
    │               │   │   ├── Return_.php
    │               │   │   ├── StaticVar.php
    │               │   │   ├── Static_.php
    │               │   │   ├── Switch_.php
    │               │   │   ├── TraitUse.php
    │               │   │   ├── TraitUseAdaptation
    │               │   │   │   ├── Alias.php
    │               │   │   │   └── Precedence.php
    │               │   │   ├── TraitUseAdaptation.php
    │               │   │   ├── Trait_.php
    │               │   │   ├── TryCatch.php
    │               │   │   ├── Unset_.php
    │               │   │   ├── UseUse.php
    │               │   │   ├── Use_.php
    │               │   │   └── While_.php
    │               │   ├── Stmt.php
    │               │   ├── UnionType.php
    │               │   ├── UseItem.php
    │               │   ├── VarLikeIdentifier.php
    │               │   └── VariadicPlaceholder.php
    │               ├── Node.php
    │               ├── NodeAbstract.php
    │               ├── NodeDumper.php
    │               ├── NodeFinder.php
    │               ├── NodeTraverser.php
    │               ├── NodeTraverserInterface.php
    │               ├── NodeVisitor
    │               │   ├── CloningVisitor.php
    │               │   ├── CommentAnnotatingVisitor.php
    │               │   ├── FindingVisitor.php
    │               │   ├── FirstFindingVisitor.php
    │               │   ├── NameResolver.php
    │               │   ├── NodeConnectingVisitor.php
    │               │   └── ParentConnectingVisitor.php
    │               ├── NodeVisitor.php
    │               ├── NodeVisitorAbstract.php
    │               ├── Parser
    │               │   ├── Php7.php
    │               │   └── Php8.php
    │               ├── Parser.php
    │               ├── ParserAbstract.php
    │               ├── ParserFactory.php
    │               ├── PhpVersion.php
    │               ├── PrettyPrinter
    │               │   └── Standard.php
    │               ├── PrettyPrinter.php
    │               ├── PrettyPrinterAbstract.php
    │               ├── Token.php
    │               └── compatibility_tokens.php
    ├── phar-io
    │   ├── manifest
    │   │   ├── CHANGELOG.md
    │   │   ├── LICENSE
    │   │   ├── README.md
    │   │   ├── composer.json
    │   │   ├── composer.lock
    │   │   ├── manifest.xsd
    │   │   ├── src
    │   │   │   ├── ManifestDocumentMapper.php
    │   │   │   ├── ManifestLoader.php
    │   │   │   ├── ManifestSerializer.php
    │   │   │   ├── exceptions
    │   │   │   │   ├── ElementCollectionException.php
    │   │   │   │   ├── Exception.php
    │   │   │   │   ├── InvalidApplicationNameException.php
    │   │   │   │   ├── InvalidEmailException.php
    │   │   │   │   ├── InvalidUrlException.php
    │   │   │   │   ├── ManifestDocumentException.php
    │   │   │   │   ├── ManifestDocumentLoadingException.php
    │   │   │   │   ├── ManifestDocumentMapperException.php
    │   │   │   │   ├── ManifestElementException.php
    │   │   │   │   ├── ManifestLoaderException.php
    │   │   │   │   └── NoEmailAddressException.php
    │   │   │   ├── values
    │   │   │   │   ├── Application.php
    │   │   │   │   ├── ApplicationName.php
    │   │   │   │   ├── Author.php
    │   │   │   │   ├── AuthorCollection.php
    │   │   │   │   ├── AuthorCollectionIterator.php
    │   │   │   │   ├── BundledComponent.php
    │   │   │   │   ├── BundledComponentCollection.php
    │   │   │   │   ├── BundledComponentCollectionIterator.php
    │   │   │   │   ├── CopyrightInformation.php
    │   │   │   │   ├── Email.php
    │   │   │   │   ├── Extension.php
    │   │   │   │   ├── Library.php
    │   │   │   │   ├── License.php
    │   │   │   │   ├── Manifest.php
    │   │   │   │   ├── PhpExtensionRequirement.php
    │   │   │   │   ├── PhpVersionRequirement.php
    │   │   │   │   ├── Requirement.php
    │   │   │   │   ├── RequirementCollection.php
    │   │   │   │   ├── RequirementCollectionIterator.php
    │   │   │   │   ├── Type.php
    │   │   │   │   └── Url.php
    │   │   │   └── xml
    │   │   │       ├── AuthorElement.php
    │   │   │       ├── AuthorElementCollection.php
    │   │   │       ├── BundlesElement.php
    │   │   │       ├── ComponentElement.php
    │   │   │       ├── ComponentElementCollection.php
    │   │   │       ├── ContainsElement.php
    │   │   │       ├── CopyrightElement.php
    │   │   │       ├── ElementCollection.php
    │   │   │       ├── ExtElement.php
    │   │   │       ├── ExtElementCollection.php
    │   │   │       ├── ExtensionElement.php
    │   │   │       ├── LicenseElement.php
    │   │   │       ├── ManifestDocument.php
    │   │   │       ├── ManifestElement.php
    │   │   │       ├── PhpElement.php
    │   │   │       └── RequiresElement.php
    │   │   └── tools
    │   │       └── php-cs-fixer.d
    │   │           ├── PhpdocSingleLineVarFixer.php
    │   │           └── header.txt
    │   └── version
    │       ├── CHANGELOG.md
    │       ├── LICENSE
    │       ├── README.md
    │       ├── composer.json
    │       └── src
    │           ├── BuildMetaData.php
    │           ├── PreReleaseSuffix.php
    │           ├── Version.php
    │           ├── VersionConstraintParser.php
    │           ├── VersionConstraintValue.php
    │           ├── VersionNumber.php
    │           ├── constraints
    │           │   ├── AbstractVersionConstraint.php
    │           │   ├── AndVersionConstraintGroup.php
    │           │   ├── AnyVersionConstraint.php
    │           │   ├── ExactVersionConstraint.php
    │           │   ├── GreaterThanOrEqualToVersionConstraint.php
    │           │   ├── OrVersionConstraintGroup.php
    │           │   ├── SpecificMajorAndMinorVersionConstraint.php
    │           │   ├── SpecificMajorVersionConstraint.php
    │           │   └── VersionConstraint.php
    │           └── exceptions
    │               ├── Exception.php
    │               ├── InvalidPreReleaseSuffixException.php
    │               ├── InvalidVersionException.php
    │               ├── NoBuildMetaDataException.php
    │               ├── NoPreReleaseSuffixException.php
    │               └── UnsupportedVersionConstraintException.php
    ├── phpstan
    │   └── phpstan
    │       ├── LICENSE
    │       ├── README.md
    │       ├── bootstrap.php
    │       ├── composer.json
    │       ├── conf
    │       │   └── bleedingEdge.neon
    │       ├── phpstan
    │       ├── phpstan.phar
    │       └── phpstan.phar.asc
    ├── phpunit
    │   ├── php-code-coverage
    │   │   ├── ChangeLog-9.2.md
    │   │   ├── LICENSE
    │   │   ├── README.md
    │   │   ├── build
    │   │   │   └── scripts
    │   │   │       └── extract-release-notes.php
    │   │   ├── composer.json
    │   │   └── src
    │   │       ├── CodeCoverage.php
    │   │       ├── Driver
    │   │       │   ├── Driver.php
    │   │       │   ├── PcovDriver.php
    │   │       │   ├── PhpdbgDriver.php
    │   │       │   ├── Selector.php
    │   │       │   ├── Xdebug2Driver.php
    │   │       │   └── Xdebug3Driver.php
    │   │       ├── Exception
    │   │       │   ├── BranchAndPathCoverageNotSupportedException.php
    │   │       │   ├── DeadCodeDetectionNotSupportedException.php
    │   │       │   ├── DirectoryCouldNotBeCreatedException.php
    │   │       │   ├── Exception.php
    │   │       │   ├── InvalidArgumentException.php
    │   │       │   ├── NoCodeCoverageDriverAvailableException.php
    │   │       │   ├── NoCodeCoverageDriverWithPathCoverageSupportAvailableException.php
    │   │       │   ├── ParserException.php
    │   │       │   ├── PathExistsButIsNotDirectoryException.php
    │   │       │   ├── PcovNotAvailableException.php
    │   │       │   ├── PhpdbgNotAvailableException.php
    │   │       │   ├── ReflectionException.php
    │   │       │   ├── ReportAlreadyFinalizedException.php
    │   │       │   ├── StaticAnalysisCacheNotConfiguredException.php
    │   │       │   ├── TestIdMissingException.php
    │   │       │   ├── UnintentionallyCoveredCodeException.php
    │   │       │   ├── WriteOperationFailedException.php
    │   │       │   ├── WrongXdebugVersionException.php
    │   │       │   ├── Xdebug2NotEnabledException.php
    │   │       │   ├── Xdebug3NotEnabledException.php
    │   │       │   ├── XdebugNotAvailableException.php
    │   │       │   └── XmlException.php
    │   │       ├── Filter.php
    │   │       ├── Node
    │   │       │   ├── AbstractNode.php
    │   │       │   ├── Builder.php
    │   │       │   ├── CrapIndex.php
    │   │       │   ├── Directory.php
    │   │       │   ├── File.php
    │   │       │   └── Iterator.php
    │   │       ├── ProcessedCodeCoverageData.php
    │   │       ├── RawCodeCoverageData.php
    │   │       ├── Report
    │   │       │   ├── Clover.php
    │   │       │   ├── Cobertura.php
    │   │       │   ├── Crap4j.php
    │   │       │   ├── Html
    │   │       │   │   ├── Facade.php
    │   │       │   │   ├── Renderer
    │   │       │   │   │   ├── Dashboard.php
    │   │       │   │   │   ├── Directory.php
    │   │       │   │   │   ├── File.php
    │   │       │   │   │   └── Template
    │   │       │   │   │       ├── branches.html.dist
    │   │       │   │   │       ├── coverage_bar.html.dist
    │   │       │   │   │       ├── coverage_bar_branch.html.dist
    │   │       │   │   │       ├── css
    │   │       │   │   │       │   ├── bootstrap.min.css
    │   │       │   │   │       │   ├── custom.css
    │   │       │   │   │       │   ├── nv.d3.min.css
    │   │       │   │   │       │   ├── octicons.css
    │   │       │   │   │       │   └── style.css
    │   │       │   │   │       ├── dashboard.html.dist
    │   │       │   │   │       ├── dashboard_branch.html.dist
    │   │       │   │   │       ├── directory.html.dist
    │   │       │   │   │       ├── directory_branch.html.dist
    │   │       │   │   │       ├── directory_item.html.dist
    │   │       │   │   │       ├── directory_item_branch.html.dist
    │   │       │   │   │       ├── file.html.dist
    │   │       │   │   │       ├── file_branch.html.dist
    │   │       │   │   │       ├── file_item.html.dist
    │   │       │   │   │       ├── file_item_branch.html.dist
    │   │       │   │   │       ├── icons
    │   │       │   │   │       │   ├── file-code.svg
    │   │       │   │   │       │   └── file-directory.svg
    │   │       │   │   │       ├── js
    │   │       │   │   │       │   ├── bootstrap.min.js
    │   │       │   │   │       │   ├── d3.min.js
    │   │       │   │   │       │   ├── file.js
    │   │       │   │   │       │   ├── jquery.min.js
    │   │       │   │   │       │   ├── nv.d3.min.js
    │   │       │   │   │       │   └── popper.min.js
    │   │       │   │   │       ├── line.html.dist
    │   │       │   │   │       ├── lines.html.dist
    │   │       │   │   │       ├── method_item.html.dist
    │   │       │   │   │       ├── method_item_branch.html.dist
    │   │       │   │   │       └── paths.html.dist
    │   │       │   │   └── Renderer.php
    │   │       │   ├── PHP.php
    │   │       │   ├── Text.php
    │   │       │   └── Xml
    │   │       │       ├── BuildInformation.php
    │   │       │       ├── Coverage.php
    │   │       │       ├── Directory.php
    │   │       │       ├── Facade.php
    │   │       │       ├── File.php
    │   │       │       ├── Method.php
    │   │       │       ├── Node.php
    │   │       │       ├── Project.php
    │   │       │       ├── Report.php
    │   │       │       ├── Source.php
    │   │       │       ├── Tests.php
    │   │       │       ├── Totals.php
    │   │       │       └── Unit.php
    │   │       ├── StaticAnalysis
    │   │       │   ├── CacheWarmer.php
    │   │       │   ├── CachingFileAnalyser.php
    │   │       │   ├── CodeUnitFindingVisitor.php
    │   │       │   ├── ExecutableLinesFindingVisitor.php
    │   │       │   ├── FileAnalyser.php
    │   │       │   ├── IgnoredLinesFindingVisitor.php
    │   │       │   └── ParsingFileAnalyser.php
    │   │       ├── Util
    │   │       │   ├── Filesystem.php
    │   │       │   └── Percentage.php
    │   │       └── Version.php
    │   ├── php-file-iterator
    │   │   ├── ChangeLog.md
    │   │   ├── LICENSE
    │   │   ├── README.md
    │   │   ├── composer.json
    │   │   └── src
    │   │       ├── Facade.php
    │   │       ├── Factory.php
    │   │       └── Iterator.php
    │   ├── php-invoker
    │   │   ├── ChangeLog.md
    │   │   ├── LICENSE
    │   │   ├── README.md
    │   │   ├── composer.json
    │   │   └── src
    │   │       ├── Invoker.php
    │   │       └── exceptions
    │   │           ├── Exception.php
    │   │           ├── ProcessControlExtensionNotLoadedException.php
    │   │           └── TimeoutException.php
    │   ├── php-text-template
    │   │   ├── ChangeLog.md
    │   │   ├── LICENSE
    │   │   ├── README.md
    │   │   ├── composer.json
    │   │   └── src
    │   │       ├── Template.php
    │   │       └── exceptions
    │   │           ├── Exception.php
    │   │           ├── InvalidArgumentException.php
    │   │           └── RuntimeException.php
    │   ├── php-timer
    │   │   ├── ChangeLog.md
    │   │   ├── LICENSE
    │   │   ├── README.md
    │   │   ├── composer.json
    │   │   └── src
    │   │       ├── Duration.php
    │   │       ├── ResourceUsageFormatter.php
    │   │       ├── Timer.php
    │   │       └── exceptions
    │   │           ├── Exception.php
    │   │           ├── NoActiveTimerException.php
    │   │           └── TimeSinceStartOfRequestNotAvailableException.php
    │   └── phpunit
    │       ├── ChangeLog-9.6.md
    │       ├── DEPRECATIONS.md
    │       ├── LICENSE
    │       ├── README.md
    │       ├── SECURITY.md
    │       ├── composer.json
    │       ├── composer.lock
    │       ├── phpunit
    │       ├── phpunit.xsd
    │       ├── schema
    │       │   ├── 8.5.xsd
    │       │   ├── 9.0.xsd
    │       │   ├── 9.1.xsd
    │       │   ├── 9.2.xsd
    │       │   ├── 9.3.xsd
    │       │   ├── 9.4.xsd
    │       │   └── 9.5.xsd
    │       └── src
    │           ├── Exception.php
    │           ├── Framework
    │           │   ├── Assert
    │           │   │   └── Functions.php
    │           │   ├── Assert.php
    │           │   ├── Constraint
    │           │   │   ├── Boolean
    │           │   │   │   ├── IsFalse.php
    │           │   │   │   └── IsTrue.php
    │           │   │   ├── Callback.php
    │           │   │   ├── Cardinality
    │           │   │   │   ├── Count.php
    │           │   │   │   ├── GreaterThan.php
    │           │   │   │   ├── IsEmpty.php
    │           │   │   │   ├── LessThan.php
    │           │   │   │   └── SameSize.php
    │           │   │   ├── Constraint.php
    │           │   │   ├── Equality
    │           │   │   │   ├── IsEqual.php
    │           │   │   │   ├── IsEqualCanonicalizing.php
    │           │   │   │   ├── IsEqualIgnoringCase.php
    │           │   │   │   └── IsEqualWithDelta.php
    │           │   │   ├── Exception
    │           │   │   │   ├── Exception.php
    │           │   │   │   ├── ExceptionCode.php
    │           │   │   │   ├── ExceptionMessage.php
    │           │   │   │   └── ExceptionMessageRegularExpression.php
    │           │   │   ├── Filesystem
    │           │   │   │   ├── DirectoryExists.php
    │           │   │   │   ├── FileExists.php
    │           │   │   │   ├── IsReadable.php
    │           │   │   │   └── IsWritable.php
    │           │   │   ├── IsAnything.php
    │           │   │   ├── IsIdentical.php
    │           │   │   ├── JsonMatches.php
    │           │   │   ├── JsonMatchesErrorMessageProvider.php
    │           │   │   ├── Math
    │           │   │   │   ├── IsFinite.php
    │           │   │   │   ├── IsInfinite.php
    │           │   │   │   └── IsNan.php
    │           │   │   ├── Object
    │           │   │   │   ├── ClassHasAttribute.php
    │           │   │   │   ├── ClassHasStaticAttribute.php
    │           │   │   │   ├── ObjectEquals.php
    │           │   │   │   ├── ObjectHasAttribute.php
    │           │   │   │   └── ObjectHasProperty.php
    │           │   │   ├── Operator
    │           │   │   │   ├── BinaryOperator.php
    │           │   │   │   ├── LogicalAnd.php
    │           │   │   │   ├── LogicalNot.php
    │           │   │   │   ├── LogicalOr.php
    │           │   │   │   ├── LogicalXor.php
    │           │   │   │   ├── Operator.php
    │           │   │   │   └── UnaryOperator.php
    │           │   │   ├── String
    │           │   │   │   ├── IsJson.php
    │           │   │   │   ├── RegularExpression.php
    │           │   │   │   ├── StringContains.php
    │           │   │   │   ├── StringEndsWith.php
    │           │   │   │   ├── StringMatchesFormatDescription.php
    │           │   │   │   └── StringStartsWith.php
    │           │   │   ├── Traversable
    │           │   │   │   ├── ArrayHasKey.php
    │           │   │   │   ├── TraversableContains.php
    │           │   │   │   ├── TraversableContainsEqual.php
    │           │   │   │   ├── TraversableContainsIdentical.php
    │           │   │   │   └── TraversableContainsOnly.php
    │           │   │   └── Type
    │           │   │       ├── IsInstanceOf.php
    │           │   │       ├── IsNull.php
    │           │   │       └── IsType.php
    │           │   ├── DataProviderTestSuite.php
    │           │   ├── Error
    │           │   │   ├── Deprecated.php
    │           │   │   ├── Error.php
    │           │   │   ├── Notice.php
    │           │   │   └── Warning.php
    │           │   ├── ErrorTestCase.php
    │           │   ├── Exception
    │           │   │   ├── ActualValueIsNotAnObjectException.php
    │           │   │   ├── AssertionFailedError.php
    │           │   │   ├── CodeCoverageException.php
    │           │   │   ├── ComparisonMethodDoesNotAcceptParameterTypeException.php
    │           │   │   ├── ComparisonMethodDoesNotDeclareBoolReturnTypeException.php
    │           │   │   ├── ComparisonMethodDoesNotDeclareExactlyOneParameterException.php
    │           │   │   ├── ComparisonMethodDoesNotDeclareParameterTypeException.php
    │           │   │   ├── ComparisonMethodDoesNotExistException.php
    │           │   │   ├── CoveredCodeNotExecutedException.php
    │           │   │   ├── Error.php
    │           │   │   ├── Exception.php
    │           │   │   ├── ExpectationFailedException.php
    │           │   │   ├── IncompleteTestError.php
    │           │   │   ├── InvalidArgumentException.php
    │           │   │   ├── InvalidCoversTargetException.php
    │           │   │   ├── InvalidDataProviderException.php
    │           │   │   ├── MissingCoversAnnotationException.php
    │           │   │   ├── NoChildTestSuiteException.php
    │           │   │   ├── OutputError.php
    │           │   │   ├── PHPTAssertionFailedError.php
    │           │   │   ├── RiskyTestError.php
    │           │   │   ├── SkippedTestError.php
    │           │   │   ├── SkippedTestSuiteError.php
    │           │   │   ├── SyntheticError.php
    │           │   │   ├── SyntheticSkippedError.php
    │           │   │   ├── UnintentionallyCoveredCodeError.php
    │           │   │   └── Warning.php
    │           │   ├── ExceptionWrapper.php
    │           │   ├── ExecutionOrderDependency.php
    │           │   ├── IncompleteTest.php
    │           │   ├── IncompleteTestCase.php
    │           │   ├── InvalidParameterGroupException.php
    │           │   ├── MockObject
    │           │   │   ├── Api
    │           │   │   │   ├── Api.php
    │           │   │   │   └── Method.php
    │           │   │   ├── Builder
    │           │   │   │   ├── Identity.php
    │           │   │   │   ├── InvocationMocker.php
    │           │   │   │   ├── InvocationStubber.php
    │           │   │   │   ├── MethodNameMatch.php
    │           │   │   │   ├── ParametersMatch.php
    │           │   │   │   └── Stub.php
    │           │   │   ├── ConfigurableMethod.php
    │           │   │   ├── Exception
    │           │   │   │   ├── BadMethodCallException.php
    │           │   │   │   ├── CannotUseAddMethodsException.php
    │           │   │   │   ├── CannotUseOnlyMethodsException.php
    │           │   │   │   ├── ClassAlreadyExistsException.php
    │           │   │   │   ├── ClassIsFinalException.php
    │           │   │   │   ├── ClassIsReadonlyException.php
    │           │   │   │   ├── ConfigurableMethodsAlreadyInitializedException.php
    │           │   │   │   ├── DuplicateMethodException.php
    │           │   │   │   ├── Exception.php
    │           │   │   │   ├── IncompatibleReturnValueException.php
    │           │   │   │   ├── InvalidMethodNameException.php
    │           │   │   │   ├── MatchBuilderNotFoundException.php
    │           │   │   │   ├── MatcherAlreadyRegisteredException.php
    │           │   │   │   ├── MethodCannotBeConfiguredException.php
    │           │   │   │   ├── MethodNameAlreadyConfiguredException.php
    │           │   │   │   ├── MethodNameNotConfiguredException.php
    │           │   │   │   ├── MethodParametersAlreadyConfiguredException.php
    │           │   │   │   ├── OriginalConstructorInvocationRequiredException.php
    │           │   │   │   ├── ReflectionException.php
    │           │   │   │   ├── ReturnValueNotConfiguredException.php
    │           │   │   │   ├── RuntimeException.php
    │           │   │   │   ├── SoapExtensionNotAvailableException.php
    │           │   │   │   ├── UnknownClassException.php
    │           │   │   │   ├── UnknownTraitException.php
    │           │   │   │   └── UnknownTypeException.php
    │           │   │   ├── Generator
    │           │   │   │   ├── deprecation.tpl
    │           │   │   │   ├── intersection.tpl
    │           │   │   │   ├── mocked_class.tpl
    │           │   │   │   ├── mocked_method.tpl
    │           │   │   │   ├── mocked_method_never_or_void.tpl
    │           │   │   │   ├── mocked_static_method.tpl
    │           │   │   │   ├── proxied_method.tpl
    │           │   │   │   ├── proxied_method_never_or_void.tpl
    │           │   │   │   ├── trait_class.tpl
    │           │   │   │   ├── wsdl_class.tpl
    │           │   │   │   └── wsdl_method.tpl
    │           │   │   ├── Generator.php
    │           │   │   ├── Invocation.php
    │           │   │   ├── InvocationHandler.php
    │           │   │   ├── Matcher.php
    │           │   │   ├── MethodNameConstraint.php
    │           │   │   ├── MockBuilder.php
    │           │   │   ├── MockClass.php
    │           │   │   ├── MockMethod.php
    │           │   │   ├── MockMethodSet.php
    │           │   │   ├── MockObject.php
    │           │   │   ├── MockTrait.php
    │           │   │   ├── MockType.php
    │           │   │   ├── Rule
    │           │   │   │   ├── AnyInvokedCount.php
    │           │   │   │   ├── AnyParameters.php
    │           │   │   │   ├── ConsecutiveParameters.php
    │           │   │   │   ├── InvocationOrder.php
    │           │   │   │   ├── InvokedAtIndex.php
    │           │   │   │   ├── InvokedAtLeastCount.php
    │           │   │   │   ├── InvokedAtLeastOnce.php
    │           │   │   │   ├── InvokedAtMostCount.php
    │           │   │   │   ├── InvokedCount.php
    │           │   │   │   ├── MethodName.php
    │           │   │   │   ├── Parameters.php
    │           │   │   │   └── ParametersRule.php
    │           │   │   ├── Stub
    │           │   │   │   ├── ConsecutiveCalls.php
    │           │   │   │   ├── Exception.php
    │           │   │   │   ├── ReturnArgument.php
    │           │   │   │   ├── ReturnCallback.php
    │           │   │   │   ├── ReturnReference.php
    │           │   │   │   ├── ReturnSelf.php
    │           │   │   │   ├── ReturnStub.php
    │           │   │   │   ├── ReturnValueMap.php
    │           │   │   │   └── Stub.php
    │           │   │   ├── Stub.php
    │           │   │   └── Verifiable.php
    │           │   ├── Reorderable.php
    │           │   ├── SelfDescribing.php
    │           │   ├── SkippedTest.php
    │           │   ├── SkippedTestCase.php
    │           │   ├── Test.php
    │           │   ├── TestBuilder.php
    │           │   ├── TestCase.php
    │           │   ├── TestFailure.php
    │           │   ├── TestListener.php
    │           │   ├── TestListenerDefaultImplementation.php
    │           │   ├── TestResult.php
    │           │   ├── TestSuite.php
    │           │   ├── TestSuiteIterator.php
    │           │   └── WarningTestCase.php
    │           ├── Runner
    │           │   ├── BaseTestRunner.php
    │           │   ├── DefaultTestResultCache.php
    │           │   ├── Exception.php
    │           │   ├── Extension
    │           │   │   ├── ExtensionHandler.php
    │           │   │   └── PharLoader.php
    │           │   ├── Filter
    │           │   │   ├── ExcludeGroupFilterIterator.php
    │           │   │   ├── Factory.php
    │           │   │   ├── GroupFilterIterator.php
    │           │   │   ├── IncludeGroupFilterIterator.php
    │           │   │   └── NameFilterIterator.php
    │           │   ├── Hook
    │           │   │   ├── AfterIncompleteTestHook.php
    │           │   │   ├── AfterLastTestHook.php
    │           │   │   ├── AfterRiskyTestHook.php
    │           │   │   ├── AfterSkippedTestHook.php
    │           │   │   ├── AfterSuccessfulTestHook.php
    │           │   │   ├── AfterTestErrorHook.php
    │           │   │   ├── AfterTestFailureHook.php
    │           │   │   ├── AfterTestHook.php
    │           │   │   ├── AfterTestWarningHook.php
    │           │   │   ├── BeforeFirstTestHook.php
    │           │   │   ├── BeforeTestHook.php
    │           │   │   ├── Hook.php
    │           │   │   ├── TestHook.php
    │           │   │   └── TestListenerAdapter.php
    │           │   ├── NullTestResultCache.php
    │           │   ├── PhptTestCase.php
    │           │   ├── ResultCacheExtension.php
    │           │   ├── StandardTestSuiteLoader.php
    │           │   ├── TestResultCache.php
    │           │   ├── TestSuiteLoader.php
    │           │   ├── TestSuiteSorter.php
    │           │   └── Version.php
    │           ├── TextUI
    │           │   ├── CliArguments
    │           │   │   ├── Builder.php
    │           │   │   ├── Configuration.php
    │           │   │   ├── Exception.php
    │           │   │   └── Mapper.php
    │           │   ├── Command.php
    │           │   ├── DefaultResultPrinter.php
    │           │   ├── Exception
    │           │   │   ├── Exception.php
    │           │   │   ├── ReflectionException.php
    │           │   │   ├── RuntimeException.php
    │           │   │   ├── TestDirectoryNotFoundException.php
    │           │   │   └── TestFileNotFoundException.php
    │           │   ├── Help.php
    │           │   ├── ResultPrinter.php
    │           │   ├── TestRunner.php
    │           │   ├── TestSuiteMapper.php
    │           │   └── XmlConfiguration
    │           │       ├── CodeCoverage
    │           │       │   ├── CodeCoverage.php
    │           │       │   ├── Filter
    │           │       │   │   ├── Directory.php
    │           │       │   │   ├── DirectoryCollection.php
    │           │       │   │   └── DirectoryCollectionIterator.php
    │           │       │   ├── FilterMapper.php
    │           │       │   └── Report
    │           │       │       ├── Clover.php
    │           │       │       ├── Cobertura.php
    │           │       │       ├── Crap4j.php
    │           │       │       ├── Html.php
    │           │       │       ├── Php.php
    │           │       │       ├── Text.php
    │           │       │       └── Xml.php
    │           │       ├── Configuration.php
    │           │       ├── Exception.php
    │           │       ├── Filesystem
    │           │       │   ├── Directory.php
    │           │       │   ├── DirectoryCollection.php
    │           │       │   ├── DirectoryCollectionIterator.php
    │           │       │   ├── File.php
    │           │       │   ├── FileCollection.php
    │           │       │   └── FileCollectionIterator.php
    │           │       ├── Generator.php
    │           │       ├── Group
    │           │       │   ├── Group.php
    │           │       │   ├── GroupCollection.php
    │           │       │   ├── GroupCollectionIterator.php
    │           │       │   └── Groups.php
    │           │       ├── Loader.php
    │           │       ├── Logging
    │           │       │   ├── Junit.php
    │           │       │   ├── Logging.php
    │           │       │   ├── TeamCity.php
    │           │       │   ├── TestDox
    │           │       │   │   ├── Html.php
    │           │       │   │   ├── Text.php
    │           │       │   │   └── Xml.php
    │           │       │   └── Text.php
    │           │       ├── Migration
    │           │       │   ├── MigrationBuilder.php
    │           │       │   ├── MigrationBuilderException.php
    │           │       │   ├── MigrationException.php
    │           │       │   ├── Migrations
    │           │       │   │   ├── ConvertLogTypes.php
    │           │       │   │   ├── CoverageCloverToReport.php
    │           │       │   │   ├── CoverageCrap4jToReport.php
    │           │       │   │   ├── CoverageHtmlToReport.php
    │           │       │   │   ├── CoveragePhpToReport.php
    │           │       │   │   ├── CoverageTextToReport.php
    │           │       │   │   ├── CoverageXmlToReport.php
    │           │       │   │   ├── IntroduceCoverageElement.php
    │           │       │   │   ├── LogToReportMigration.php
    │           │       │   │   ├── Migration.php
    │           │       │   │   ├── MoveAttributesFromFilterWhitelistToCoverage.php
    │           │       │   │   ├── MoveAttributesFromRootToCoverage.php
    │           │       │   │   ├── MoveWhitelistExcludesToCoverage.php
    │           │       │   │   ├── MoveWhitelistIncludesToCoverage.php
    │           │       │   │   ├── RemoveCacheTokensAttribute.php
    │           │       │   │   ├── RemoveEmptyFilter.php
    │           │       │   │   ├── RemoveLogTypes.php
    │           │       │   │   └── UpdateSchemaLocationTo93.php
    │           │       │   └── Migrator.php
    │           │       ├── PHP
    │           │       │   ├── Constant.php
    │           │       │   ├── ConstantCollection.php
    │           │       │   ├── ConstantCollectionIterator.php
    │           │       │   ├── IniSetting.php
    │           │       │   ├── IniSettingCollection.php
    │           │       │   ├── IniSettingCollectionIterator.php
    │           │       │   ├── Php.php
    │           │       │   ├── PhpHandler.php
    │           │       │   ├── Variable.php
    │           │       │   ├── VariableCollection.php
    │           │       │   └── VariableCollectionIterator.php
    │           │       ├── PHPUnit
    │           │       │   ├── Extension.php
    │           │       │   ├── ExtensionCollection.php
    │           │       │   ├── ExtensionCollectionIterator.php
    │           │       │   └── PHPUnit.php
    │           │       └── TestSuite
    │           │           ├── TestDirectory.php
    │           │           ├── TestDirectoryCollection.php
    │           │           ├── TestDirectoryCollectionIterator.php
    │           │           ├── TestFile.php
    │           │           ├── TestFileCollection.php
    │           │           ├── TestFileCollectionIterator.php
    │           │           ├── TestSuite.php
    │           │           ├── TestSuiteCollection.php
    │           │           └── TestSuiteCollectionIterator.php
    │           └── Util
    │               ├── Annotation
    │               │   ├── DocBlock.php
    │               │   └── Registry.php
    │               ├── Blacklist.php
    │               ├── Cloner.php
    │               ├── Color.php
    │               ├── ErrorHandler.php
    │               ├── Exception.php
    │               ├── ExcludeList.php
    │               ├── FileLoader.php
    │               ├── Filesystem.php
    │               ├── Filter.php
    │               ├── GlobalState.php
    │               ├── InvalidDataSetException.php
    │               ├── Json.php
    │               ├── Log
    │               │   ├── JUnit.php
    │               │   └── TeamCity.php
    │               ├── PHP
    │               │   ├── AbstractPhpProcess.php
    │               │   ├── DefaultPhpProcess.php
    │               │   ├── Template
    │               │   │   ├── PhptTestCase.tpl
    │               │   │   ├── TestCaseClass.tpl
    │               │   │   └── TestCaseMethod.tpl
    │               │   └── WindowsPhpProcess.php
    │               ├── Printer.php
    │               ├── Reflection.php
    │               ├── RegularExpression.php
    │               ├── Test.php
    │               ├── TestDox
    │               │   ├── CliTestDoxPrinter.php
    │               │   ├── HtmlResultPrinter.php
    │               │   ├── NamePrettifier.php
    │               │   ├── ResultPrinter.php
    │               │   ├── TestDoxPrinter.php
    │               │   ├── TextResultPrinter.php
    │               │   └── XmlResultPrinter.php
    │               ├── TextTestListRenderer.php
    │               ├── Type.php
    │               ├── VersionComparisonOperator.php
    │               ├── XdebugFilterScriptGenerator.php
    │               ├── Xml
    │               │   ├── Exception.php
    │               │   ├── FailedSchemaDetectionResult.php
    │               │   ├── Loader.php
    │               │   ├── SchemaDetectionResult.php
    │               │   ├── SchemaDetector.php
    │               │   ├── SchemaFinder.php
    │               │   ├── SnapshotNodeList.php
    │               │   ├── SuccessfulSchemaDetectionResult.php
    │               │   ├── ValidationResult.php
    │               │   └── Validator.php
    │               ├── Xml.php
    │               └── XmlTestListRenderer.php
    ├── psr
    │   ├── cache
    │   │   ├── CHANGELOG.md
    │   │   ├── LICENSE.txt
    │   │   ├── README.md
    │   │   ├── composer.json
    │   │   └── src
    │   │       ├── CacheException.php
    │   │       ├── CacheItemInterface.php
    │   │       ├── CacheItemPoolInterface.php
    │   │       └── InvalidArgumentException.php
    │   └── http-message
    │       ├── CHANGELOG.md
    │       ├── LICENSE
    │       ├── README.md
    │       ├── composer.json
    │       ├── docs
    │       │   ├── PSR7-Interfaces.md
    │       │   └── PSR7-Usage.md
    │       └── src
    │           ├── MessageInterface.php
    │           ├── RequestInterface.php
    │           ├── ResponseInterface.php
    │           ├── ServerRequestInterface.php
    │           ├── StreamInterface.php
    │           ├── UploadedFileInterface.php
    │           └── UriInterface.php
    ├── sebastian
    │   ├── cli-parser
    │   │   ├── ChangeLog.md
    │   │   ├── LICENSE
    │   │   ├── README.md
    │   │   ├── composer.json
    │   │   ├── infection.json
    │   │   └── src
    │   │       ├── Parser.php
    │   │       └── exceptions
    │   │           ├── AmbiguousOptionException.php
    │   │           ├── Exception.php
    │   │           ├── OptionDoesNotAllowArgumentException.php
    │   │           ├── RequiredOptionArgumentMissingException.php
    │   │           └── UnknownOptionException.php
    │   ├── code-unit
    │   │   ├── ChangeLog.md
    │   │   ├── LICENSE
    │   │   ├── README.md
    │   │   ├── composer.json
    │   │   └── src
    │   │       ├── ClassMethodUnit.php
    │   │       ├── ClassUnit.php
    │   │       ├── CodeUnit.php
    │   │       ├── CodeUnitCollection.php
    │   │       ├── CodeUnitCollectionIterator.php
    │   │       ├── FunctionUnit.php
    │   │       ├── InterfaceMethodUnit.php
    │   │       ├── InterfaceUnit.php
    │   │       ├── Mapper.php
    │   │       ├── TraitMethodUnit.php
    │   │       ├── TraitUnit.php
    │   │       └── exceptions
    │   │           ├── Exception.php
    │   │           ├── InvalidCodeUnitException.php
    │   │           ├── NoTraitException.php
    │   │           └── ReflectionException.php
    │   ├── code-unit-reverse-lookup
    │   │   ├── ChangeLog.md
    │   │   ├── LICENSE
    │   │   ├── README.md
    │   │   ├── composer.json
    │   │   └── src
    │   │       └── Wizard.php
    │   ├── comparator
    │   │   ├── ChangeLog.md
    │   │   ├── LICENSE
    │   │   ├── README.md
    │   │   ├── composer.json
    │   │   └── src
    │   │       ├── ArrayComparator.php
    │   │       ├── Comparator.php
    │   │       ├── ComparisonFailure.php
    │   │       ├── DOMNodeComparator.php
    │   │       ├── DateTimeComparator.php
    │   │       ├── DoubleComparator.php
    │   │       ├── ExceptionComparator.php
    │   │       ├── Factory.php
    │   │       ├── MockObjectComparator.php
    │   │       ├── NumericComparator.php
    │   │       ├── ObjectComparator.php
    │   │       ├── ResourceComparator.php
    │   │       ├── ScalarComparator.php
    │   │       ├── SplObjectStorageComparator.php
    │   │       ├── TypeComparator.php
    │   │       └── exceptions
    │   │           ├── Exception.php
    │   │           └── RuntimeException.php
    │   ├── complexity
    │   │   ├── ChangeLog.md
    │   │   ├── LICENSE
    │   │   ├── README.md
    │   │   ├── composer.json
    │   │   └── src
    │   │       ├── Calculator.php
    │   │       ├── Complexity
    │   │       │   ├── Complexity.php
    │   │       │   ├── ComplexityCollection.php
    │   │       │   └── ComplexityCollectionIterator.php
    │   │       ├── Exception
    │   │       │   ├── Exception.php
    │   │       │   └── RuntimeException.php
    │   │       └── Visitor
    │   │           ├── ComplexityCalculatingVisitor.php
    │   │           └── CyclomaticComplexityCalculatingVisitor.php
    │   ├── diff
    │   │   ├── ChangeLog.md
    │   │   ├── LICENSE
    │   │   ├── README.md
    │   │   ├── composer.json
    │   │   └── src
    │   │       ├── Chunk.php
    │   │       ├── Diff.php
    │   │       ├── Differ.php
    │   │       ├── Exception
    │   │       │   ├── ConfigurationException.php
    │   │       │   ├── Exception.php
    │   │       │   └── InvalidArgumentException.php
    │   │       ├── Line.php
    │   │       ├── LongestCommonSubsequenceCalculator.php
    │   │       ├── MemoryEfficientLongestCommonSubsequenceCalculator.php
    │   │       ├── Output
    │   │       │   ├── AbstractChunkOutputBuilder.php
    │   │       │   ├── DiffOnlyOutputBuilder.php
    │   │       │   ├── DiffOutputBuilderInterface.php
    │   │       │   ├── StrictUnifiedDiffOutputBuilder.php
    │   │       │   └── UnifiedDiffOutputBuilder.php
    │   │       ├── Parser.php
    │   │       └── TimeEfficientLongestCommonSubsequenceCalculator.php
    │   ├── environment
    │   │   ├── ChangeLog.md
    │   │   ├── LICENSE
    │   │   ├── README.md
    │   │   ├── composer.json
    │   │   └── src
    │   │       ├── Console.php
    │   │       ├── OperatingSystem.php
    │   │       └── Runtime.php
    │   ├── exporter
    │   │   ├── ChangeLog.md
    │   │   ├── LICENSE
    │   │   ├── README.md
    │   │   ├── composer.json
    │   │   └── src
    │   │       └── Exporter.php
    │   ├── global-state
    │   │   ├── ChangeLog.md
    │   │   ├── LICENSE
    │   │   ├── README.md
    │   │   ├── composer.json
    │   │   └── src
    │   │       ├── CodeExporter.php
    │   │       ├── ExcludeList.php
    │   │       ├── Restorer.php
    │   │       ├── Snapshot.php
    │   │       └── exceptions
    │   │           ├── Exception.php
    │   │           └── RuntimeException.php
    │   ├── lines-of-code
    │   │   ├── ChangeLog.md
    │   │   ├── LICENSE
    │   │   ├── README.md
    │   │   ├── composer.json
    │   │   └── src
    │   │       ├── Counter.php
    │   │       ├── Exception
    │   │       │   ├── Exception.php
    │   │       │   ├── IllogicalValuesException.php
    │   │       │   ├── NegativeValueException.php
    │   │       │   └── RuntimeException.php
    │   │       ├── LineCountingVisitor.php
    │   │       └── LinesOfCode.php
    │   ├── object-enumerator
    │   │   ├── ChangeLog.md
    │   │   ├── LICENSE
    │   │   ├── README.md
    │   │   ├── composer.json
    │   │   ├── phpunit.xml
    │   │   └── src
    │   │       ├── Enumerator.php
    │   │       ├── Exception.php
    │   │       └── InvalidArgumentException.php
    │   ├── object-reflector
    │   │   ├── ChangeLog.md
    │   │   ├── LICENSE
    │   │   ├── README.md
    │   │   ├── composer.json
    │   │   └── src
    │   │       ├── Exception.php
    │   │       ├── InvalidArgumentException.php
    │   │       └── ObjectReflector.php
    │   ├── recursion-context
    │   │   ├── ChangeLog.md
    │   │   ├── LICENSE
    │   │   ├── README.md
    │   │   ├── composer.json
    │   │   └── src
    │   │       ├── Context.php
    │   │       ├── Exception.php
    │   │       └── InvalidArgumentException.php
    │   ├── resource-operations
    │   │   ├── ChangeLog.md
    │   │   ├── LICENSE
    │   │   ├── README.md
    │   │   ├── SECURITY.md
    │   │   ├── build
    │   │   │   └── generate.php
    │   │   ├── composer.json
    │   │   └── src
    │   │       └── ResourceOperations.php
    │   ├── type
    │   │   ├── ChangeLog.md
    │   │   ├── LICENSE
    │   │   ├── README.md
    │   │   ├── composer.json
    │   │   └── src
    │   │       ├── Parameter.php
    │   │       ├── ReflectionMapper.php
    │   │       ├── TypeName.php
    │   │       ├── exception
    │   │       │   ├── Exception.php
    │   │       │   └── RuntimeException.php
    │   │       └── type
    │   │           ├── CallableType.php
    │   │           ├── FalseType.php
    │   │           ├── GenericObjectType.php
    │   │           ├── IntersectionType.php
    │   │           ├── IterableType.php
    │   │           ├── MixedType.php
    │   │           ├── NeverType.php
    │   │           ├── NullType.php
    │   │           ├── ObjectType.php
    │   │           ├── SimpleType.php
    │   │           ├── StaticType.php
    │   │           ├── TrueType.php
    │   │           ├── Type.php
    │   │           ├── UnionType.php
    │   │           ├── UnknownType.php
    │   │           └── VoidType.php
    │   └── version
    │       ├── ChangeLog.md
    │       ├── LICENSE
    │       ├── README.md
    │       ├── composer.json
    │       └── src
    │           └── Version.php
    └── theseer
        └── tokenizer
            ├── CHANGELOG.md
            ├── LICENSE
            ├── README.md
            ├── composer.json
            ├── composer.lock
            └── src
                ├── Exception.php
                ├── NamespaceUri.php
                ├── NamespaceUriException.php
                ├── Token.php
                ├── TokenCollection.php
                ├── TokenCollectionException.php
                ├── Tokenizer.php
                └── XMLSerializer.php

224 directories, 1241 files

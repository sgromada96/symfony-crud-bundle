Example of use:

'
#[Route('example', name: 'panel_example_')]
class ExampleController extends AbstractController
{
    use CrudTrait;

    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected string $class = Example::class,
        protected string $form = ExampleFormType::class,
        protected string $templatePath = 'example',
    ) {
    }
}
''

Then create twig files in directory  and call routes
example/index.html.twig => panel_example_index
example/show.html.twig => panel_example_show
example/update.html.twig => panel_example_update
example/create.html.twig => panel_example_create

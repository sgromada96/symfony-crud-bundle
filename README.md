Example of use:

#[Route('examination', name: 'panel_examination_')]
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

Then create twig files in directory 
example/index.html.twig,
example/show.html.twig,
example/update.html.twig,
example/create.html.twig,

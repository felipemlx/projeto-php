<?php
namespace Felipe\Controller;
use Felipe\Repository\VideoRepository;
use Felipe\Entity\Video;
use Felipe\Helper\FlashMessageTrait;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
class NewVideoController implements RequestHandlerInterface
{
    use FlashMessageTrait;
    public function __construct(private VideoRepository $videoRepository)
    {
        
    }
    public function handle(ServerRequestInterface $request):ResponseInterface
    {
        $requestBody = $request->getParsedBody();
        $url = filter_var($requestBody['url'],FILTER_VALIDATE_URL);
        if ($url === false){
            $this->addErrorMessage('URL Inválida');
            return new Response(302,['Location' => '/']);
        }
        $titulo = filter_var($requestBody['titulo']);
        if ($titulo === false){
            $this->addErrorMessage('Titulo Inválida');
            return new Response(302,['Location' => '/']);
        }
        $video = new Video($url,$titulo);
        $files = $request->getUploadedFiles();
        $uploadedImage = $files['image'];
        if ($uploadedImage->getError() === UPLOAD_ERR_OK){
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $tmpFile = $uploadedImage->getStream()->getMetadata('uri');
            $mimeType = $finfo->file($tmpFile);
            if (str_starts_with($mimeType,'image/')){
                $safeFileName = uniqid('upload_') . '_' . pathinfo($uploadedImage->getClientFilename(),PATHINFO_BASENAME);
                $uploadedImage->moveTo(__DIR__ . '/../../public/img/uploads/' . $safeFileName);
                $video->setFilePath($safeFileName);
            }
        }
        $success = $this->videoRepository->add($video);
        if ($success === false) {
            $this->addErrorMessage('Erro ao cadastrar vídeo');
            return new Response(302, [
                'Location' => '/novo-video'
            ]);
        }

        return new Response(302, [
            'Location' => '/'
        ]);
    }
}
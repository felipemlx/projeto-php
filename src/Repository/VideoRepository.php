<?php

declare(strict_types=1);

namespace Felipe\Repository;
use Felipe\Entity\Video;
use PDO;
class VideoRepository
{
    public function __construct(private PDO $pdo)
    {
        
    }

    public function add(Video $video): bool
    {
        $statement = $this->pdo->prepare('INSERT INTO videos(url,title, image_path) VALUES(:url,:title,:image_path);');
        $statement->bindValue('url',$video->url);
        $statement->bindValue('title',$video->title);
        $statement->bindValue('image_path',$video->getFilePath());
        $result = $statement->execute();

        $id = $this->pdo->lastInsertId();

        $video->setId(intval($id));
        return $result;
    }

    public function remove(int $id): bool
    {
        $sql = 'DELETE FROM videos WHERE id = :id';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue('id',$id);
        return $statement->execute();
    }

    public function update(Video $video): bool
    {
        if ($video->getFilePath() !== null){
            $updateImageSql = ', image_path = :image_path';
        }
        $sql = "UPDATE videos SET url = :url, title = :title $updateImageSql WHERE id = :id;";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue('url',$video->url);
        $statement->bindValue('title',$video->title);
        $statement->bindValue('id',$video->id,PDO::PARAM_INT);
        if ($video->getFilePath() !== null){
            $statement->bindValue('image_path',$video->getFilePath());
        }

        return $statement->execute();
    }
    /**
     * @return Video[]
     */
    public function all(): array
    {
        $videoList = $this->pdo->query('SELECT * FROM videos;')->fetchAll(\PDO::FETCH_ASSOC);
        return array_map(
            function (array $videoData){
                $video = new Video($videoData['url'],$videoData['title']);
                $video->setId($videoData['id']);

                return $video;
            },
            $videoList
        );
    }
    public function find(int $id)
    {
        $statement = $this->pdo->prepare('SELECT * FROM videos WHERE id = :id;');
        $statement->bindValue('id',$id,\PDO::PARAM_INT);
        $statement->execute();
        return $this->hydrateVideo($statement->fetch(\PDO::FETCH_ASSOC));
    }
    private function hydrateVideo(array $videoData): Video
    {
        $video = new Video($videoData['url'],$videoData['title']);
        $video->setId($videoData['id']);
        if ($videoData['image_path'] !== null ){
            $video->setFilePath($videoData['image_path']);
        }
        return $video;
    }
}
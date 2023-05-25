<?php

declare(strict_types=1);

class Tag
{

    public int $ticket_id;
    public string $tag;


    public function __construct(int $tic_id, string $tag)
    {
        $this->ticket_id = $tic_id;
        $this->tag = $tag;
    }

    public function getTicketId(): ?int
    {

        return $this->ticket_id;
    }


    public function getTag(): ?string
    {

        return $this->tag;
    }



    static public function getTagsWithTicketId(PDO $db, int $id)
    {
        $stmt = $db->prepare('SELECT ticket_id, tag
            FROM tags            
            WHERE ticket_id = ?
            ');

        $stmt->execute(array($id));

        $tags = array();

        while ($tag = $stmt->fetch()) {

            $tags[] = new Tag(
                intval($tag['ticket_id']),
                $tag['tag']
            );
        }

        return $tags;
    }

    function addTag(PDO $db){
        $stmt = $db->prepare('INSERT INTO tags (ticket_id, tag) VALUES (?, ?)');
        $stmt->execute([$this->ticket_id, $this->tag]);
    }

    function deleteTag(PDO $db){
        $stmt = $db->prepare('DELETE FROM tags WHERE ticket_id = ? AND tag = ?');
        $stmt->execute([$this->ticket_id, $this->tag]);
    }
}

function getTagsMatch(PDO $db, string $input) :array{
    $stmt = $db->prepare('SELECT tag FROM tags WHERE tag LIKE :input');
    $stmt->bindValue(':input', '%' . $input . '%');
    $stmt->execute([$input . '%']);

    $tags = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo var_dump($tags);
    echo json_encode($tags);
    return $tags;
}

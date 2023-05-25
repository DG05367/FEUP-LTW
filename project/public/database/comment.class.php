<?php

declare(strict_types=1);

class Comment
{
    public int $comment_id;
    public int $ticket_id;
    public int $agent_id;
    public string $comment;
    public string $created_at;

    public function __construct(int $com_id, int $tic_id, int $ag_id, string $com, string $ca)
    {
        $this->comment_id = $com_id;
        $this->ticket_id = $tic_id;
        $this->agent_id = $ag_id;
        $this->comment = $com;
        $this->created_at = $ca;
    }

    public function getCommentId(): ?int
    {

        return $this->comment_id;
    }

    public function getTicketId(): ?int
    {

        return $this->ticket_id;
    }

    public function getAgentId(): ?int
    {

        return $this->agent_id;
    }

    public function getComment(): ?string
    {

        return $this->comment;
    }

    public function getCreatedAt(): ?string
    {

        return $this->created_at;
    }

    static public function getCommentsWithTicketId(PDO $db, int $id)
    {
        $stmt = $db->prepare('SELECT comment_id, ticket_id, agent_id, comment, created_at
            FROM comments            
            WHERE comments.ticket_id = ?
            ');

        $stmt->execute(array($id));

        $comments = array();

        while ($comment = $stmt->fetch()) {

            $comments[] = new Comment(
                intval($comment['comment_id']),
                intval($comment['ticket_id']),
                intval($comment['agent_id']),
                $comment['comment'],
                $comment['created_at']
            );
        }

        return $comments;
    }
}

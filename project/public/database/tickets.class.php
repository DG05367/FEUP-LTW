<?php
    declare(strict_types=1);

    require_once('user.class.php');

    class Ticket{
        public int $ticket_id;
        public int $client_id;
        public int $department_id;
        public string $username;
        public string $title;
        public string $description;

        public function __construct(int $ticket_id, int $client_id, string $username, string $title, string $description){
            $this->ticket_id = $ticket_id;
            $this->client_id = $client_id;
            $this->username = $username;
            $this->title = $title;
            $this->description = $description;
        }

        public function getUsername() : ?string{
            return $this->username;
        }

        public function getClientId() : ?int{
            return $this->client_id;
        }

        public function getId() : ?int{
            return $this->ticket_id;
        }

        public function getTitle() : ?string{
            return $this->title;
        }

        public function getDescription() : ?string{
            return $this->description;
        }

        static function getTicketsByDepartment(PDO $db, int $count, int $dep_id, string $filter){
            $orderBy = "";

            switch ($filter) {
                case "recent":
                    $orderBy = "created_at DESC";
                case "title":
                    $orderBy = "title";
                    break;
                case "open":
                    $orderBy = "status_id = '1' DESC";
                    break;
                case "closed":
                    $orderBy = "status_id = '3' DESC";
                    break;
                case "department":
                    $orderBy = "department_id";
                    break;
                default:
                    $orderBy = "created_at DESC";
                    break;
            }

            $stmt = $db->prepare('SELECT ticket_id, client_id, title, description, created_at
            FROM tickets
            WHERE department_id = ?
            ORDER BY ' . $orderBy . ' 
            LIMIT ?');

            $stmt->execute([$dep_id, $count]);

            $tickets = array();

            while ($ticket = $stmt->fetch()) {
                $username = Client::getUsername($db, intval($ticket['client_id']));
                $tickets[] = new Ticket(
                    intval($ticket['ticket_id']),
                    intval($ticket['client_id']),
                    $username,
                    $ticket['title'],
                    $ticket['description']
                );
                }
    
            return $tickets;
        }

        static function getTicketsProfile(PDO $db, int $count, int $id){
            $stmt = $db->prepare('SELECT ticket_id, client_id, username, title, description
            FROM client, ticket
            WHERE client.client_id = ?
            GROUP BY ticket.author_id');
    
            $stmt->execute(array($id));
    
            $tickets = array();
    
            while($ticket = $stmt->fetch()){
                $username = Client::getUsername($db, intval($ticket['client_id']));
                $tickets[] = new Ticket(
                    intval($ticket['ticket_id']),
                    $ticket['client_id'],
                    $username,
                    $ticket['title'],
                    $ticket['description']
                );
            }
    
            return $tickets;
    
        }

        static function getTicket(PDO $db, int $id){
            $stmt = $db->prepare('SELECT ticket_id, client_id, title, description
            FROM tickets
            WHERE ticket_id = ?
            ');
    
            $stmt->execute(array($id));

            $ticket = $stmt->fetch();
            $username = Client::getUsername($db, intval($ticket['client_id']));
            return new Ticket(
                    intval($ticket['ticket_id']),
                    intval($ticket['client_id']),
                    $username,
                    $ticket['title'],
                    $ticket['description']
                );
        }
    
        static function getTicketsAssigned(PDO $db, int $id){
            $stmt = $db->prepare('SELECT ticket_id, client_id, title, description
            FROM tickets
            WHERE tickets.agent_id = ?');
    
            $stmt->execute(array($id));
    
            $tickets = array();
    
            while($ticket = $stmt->fetch()){
                $username = Client::getUsername($db, intval($ticket['client_id']));
                $tickets[] = new Ticket(
                    intval($ticket['ticket_id']),
                    intval($ticket['client_id']),
                    $username,
                    $ticket['title'],
                    $ticket['description']
                );
            }
    
            return $tickets;
        }
    
    static function getTickets(PDO $db, int $count, string $filter = "recent"){
        $orderBy = "";

        switch ($filter) {
            case "recent":
                $orderBy = "created_at";
                break;
            case "title":
                $orderBy = "title";
                break;
            case "open":
                $orderBy = "status_id = '1' DESC";
                break;
            case "closed":
                $orderBy = "status_id = '3' DESC";
                break;
            case "department":
                $orderBy = "department_id";
                break;
            default:
                $orderBy = "created_at DESC";
                break;
        }

        $stmt = $db->prepare('SELECT ticket_id, client_id, title, description
            FROM tickets
            ORDER BY ' . $orderBy . ' 
            LIMIT ?');
        $stmt->execute([$count]);

        $tickets = array();

        while ($ticket = $stmt->fetch()) {
            $username = Client::getUsername($db, intval($ticket['client_id']));
            $tickets[] = new Ticket(
                intval($ticket['ticket_id']),
                intval($ticket['client_id']),
                $username,
                $ticket['title'],
                $ticket['description']
            );
            }

        return $tickets;
    }

    public function getDepartmentId(PDO $db): ?int{
        $stmt = $db->prepare('SELECT department_id FROM tickets WHERE ?');
        $stmt->execute([$this->getId()]);

        $department = $stmt->fetch();

        return intval($department['department_id']);
    }

    function alterDepartment(PDO $db, int $new_dep){
        $stmt = $db->prepare('UPDATE tickets SET department_id = ? WHERE ticket_id = ?');
        $stmt->execute([$new_dep, $this->getId()]);
    }

    function isAssigned(PDO $db){
        $stmt = $db->prepare('SELECT agent_id FROM tickets WHERE ticket_id = ?');
        $stmt->execute([$this->ticket_id]);
        $status = $stmt->fetch(PDO::FETCH_ASSOC);
        if($status['agent_id'] == null){
            return false;
        }
        return true;
    }

    function AssignTicket(PDO $db, int $agent_id){
        $stmt = $db->prepare('UPDATE tickets SET agent_id = ? WHERE ticket_id = ?');
        $stmt->execute([$agent_id, $this->ticket_id]);
    }

    function getAgentAssigned(PDO $db): ?int{
        $stmt = $db->prepare('SELECT agent_id FROM tickets WHERE ticket_id = ?');
        $stmt->execute([$this->ticket_id]);

        $agent = $stmt->fetch(PDO::FETCH_ASSOC);

        return intval($agent['agent_id']);
    }

    function getStatus($db): ?int{
        $stmt = $db->prepare('SELECT status_id FROM tickets WHERE ticket_id = ?');
        $stmt->execute([$this->ticket_id]);

        $status = $stmt->fetch(PDO::FETCH_ASSOC);

        return intval($status['status_id']);
    }
}

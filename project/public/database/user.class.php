<?php

declare(strict_types=1);

class Client
{
  public int $client_id;
  public string $name;
  public string $email;
  public string $username;
  public string $password;


  public function __construct(int $id, string $name, string $email, string $username, string $password)
  {

    $this->client_id = $id;
    $this->name = $name;
    $this->email = $email;
    $this->username = $username;
    $this->password = $password;
  }

  public function getClientId(): ?int
  {
    return $this->client_id;
  }

  public function getClientName(): ?string
  {
    return $this->name;
  }

  public function getClientEmail(): ?string
  {
    return $this->email;
  }

  public function getClientUsername(): ?string
  {
    return $this->username;
  }

  public static function getClient(PDO $db, int $id): Client
  {
    $stmt = $db->prepare(
      'SELECT client_id, name, email, username, password
      FROM clients
      WHERE client_id = ?'
    );
    $stmt->execute(array($id));

    $profile = $stmt->fetch();

    return new Client(
      intval($profile['client_id']),
      $profile['name'],
      $profile['email'],
      $profile['username'],
      $profile['password']

    );
  }

  public function changeName(PDO $db)
  {
    $stmt = $db->prepare('
        UPDATE clients SET name = ?
        WHERE client_id = ?
      ');

    $stmt->execute(array($this->name, $this->client_id));
  }

  public function changeEmail(PDO $db)
  {
    $stmt = $db->prepare('
        UPDATE clients SET email = ?
        WHERE client_id = ?
      ');

    $stmt->execute(array($this->email, $this->client_id));
  }

  public function changeUsername(PDO $db)
  {
    $stmt = $db->prepare('
        UPDATE clients SET username = ?
        WHERE client_id = ?
      ');

    $stmt->execute(array($this->username, $this->client_id));
  }

  public function changePassword(PDO $db)
  {
    $stmt = $db->prepare('
        UPDATE clients SET password = ?
        WHERE client_id = ?
      ');

    $stmt->execute(array($this->password, $this->client_id));
  }

  public function save(PDO $db)
  {
    $stmt = $db->prepare('
        UPDATE clients SET name = ?, email = ?, username = ?, password = ?
        WHERE client_id = ?
      ');

    $stmt->execute(array($this->name, $this->email, $this->username, $this->password, $this->client_id));
  }

  public static function getUsername(PDO $db, int $id): ?string
  {
    $stmt = $db->prepare('SELECT username FROM clients WHERE client_id = ?');
    $stmt->execute(array($id));

    $profile = $stmt->fetch();

    if ($profile) {
      return $profile['username'];
    }

    return null;
  }

  public static function getId(PDO $db, string $username): ?int
  {
    $stmt = $db->prepare('SELECT client_id FROM clients WHERE username = ?');
    $stmt->execute(array($username));

    $profile = $stmt->fetch();

    if ($profile) {
      return intval($profile['client_id']);
    }

    return null;
  }

  public function upgradeToAgent(PDO $db, int $departmentId)
  {
    $stmt = $db->prepare('INSERT INTO agents (agent_id, department_id) VALUES (?, ?)');
    $stmt->execute([$this->client_id, $departmentId]);
  }

  public function upgradeToAdmin(PDO $db)
  {
    $stmt = $db->prepare('INSERT INTO admins (admin_id) VALUES (?)');
    $stmt->execute([$this->client_id]);
  }

  public function downgradeToAgent(PDO $db){
    $stmt = $db->prepare('DELETE FROM admins WHERE admin_id = ?');
    $stmt->execute([$this->client_id]);
  }

  public function downgradeToClient(PDO $db){
    $stmt = $db->prepare('DELETE FROM agents WHERE agent_id = ?');
    $stmt->execute([$this->client_id]);
  }

  public function getDepartmentIdClientSide(PDO $db): int{
    $stmt = $db->prepare('SELECT department_id FROM agents WHERE agent_id = ?');
    $stmt->execute([$this->client_id]);

    $dep_id = $stmt->fetch(PDO::FETCH_ASSOC);

    return intval($dep_id['department_id']);
  }
}

class Agent extends Client
{
  public int $department_id;

  public function __construct(int $id, string $name, string $email, string $username, string $password, int $dep_id)
  {

    $this->client_id = $id;
    $this->name = $name;
    $this->email = $email;
    $this->username = $username;
    $this->password = $password;
    $this->department_id = $dep_id;
  }

  public function getDepartment_id(): ?int{
    return $this->department_id;
  }

  public static function getAgent(PDO $db, int $id): Agent
  {
    $stmt = $db->prepare(
      'SELECT client_id, name, email, username, password, department_id
      FROM clients JOIN agents ON clients.client_id = agents.agent_id
      WHERE client_id = ?'
    );
    $stmt->execute(array($id));

    $profile = $stmt->fetch();

    return new Agent(
      intval($profile['client_id']),
      $profile['name'],
      $profile['email'],
      $profile['username'],
      $profile['password'],
      intval($profile['department_id']),
    );
  }

  public function changeTicketDepartment(PDO $db, $ticketid, $newdepartment)
  {
    // Maybe check if new department isValid?
    // Updates with new department ID
    $stmt = $db->prepare('UPDATE tickets SET department_id = ? WHERE ticket_id = ?');
    $stmt->execute([$newdepartment, $ticketid]);
  }
}
class Admin extends Agent
{
  public function __construct(int $id, string $name, string $email, string $username, string $password, int $dep_id)
  {

    $this->client_id = $id;
    $this->name = $name;
    $this->email = $email;
    $this->username = $username;
    $this->password = $password;
    $this->department_id = $dep_id;
  }


}

function assignAgentToDepartment(PDO $db, $agentId, $departmentId)
{
    // Check if the agent and department exist
    $agentExists = checkAgent($db, $agentId);
    $departmentExists = checkDepartment($db, $departmentId);

    if (!$agentExists || !$departmentExists) {
      $_SESSION['error'] = 'Something went wrong.';
      exit();
    }

    // Assign the agent to the department
    $query = "UPDATE agents SET department_id = :departmentId WHERE agent_id = :agentId";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':departmentId', $departmentId, PDO::PARAM_INT);
    $stmt->bindParam(':agentId', $agentId, PDO::PARAM_INT);

    try {
        $stmt->execute();
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Something went wrong.';
    }

    header("Location: ../pages/admin.php");
    exit();
}

<?php

declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/department.db.php');
require_once(__DIR__ . '/../database/tickets.class.php');
require_once(__DIR__ . '/../database/status.db.php');
?>

<?php function drawTickets(PDO $db, array $tickets, int $id, string $filter)
{ ?>
  <h2>Tickets</h2>
  <script src='../javascript/autocomplete.js'></script>

  <label for="filter">Order by:</label>

  <select id="filter" onchange="applyFilter(this.value)">
    <option value="recent" <?php echo ($filter === 'recent') ? 'selected' : ''; ?>>Recent</option>
    <option value="closed" <?php echo ($filter === 'closed') ? 'selected' : ''; ?>>Closed tickets</option>
    <option value="open" <?php echo ($filter === 'open') ? 'selected' : ''; ?>>Open tickets</option>
    <option value="title" <?php echo ($filter === 'title') ? 'selected' : ''; ?>>Title</option>
    <option value="department" <?php echo ($filter === 'department') ? 'selected' : ''; ?>>Department</option>
  </select>

  <section id="tickets">


    <?php foreach ($tickets as $ticket) { ?>
      <article>
        <a href="profile.php?username=<?= $ticket->getUsername() ?>"><?= $ticket->getUsername() ?></a>
        <h3><a href="ticket_page.php?id=<?= $ticket->getId() ?>"><?= $ticket->getTitle() ?></a></h3>
        <p><?= $ticket->getDescription() ?></p>

        <?php if (checkAdmin($db, $id)) {
          $stmt = $db->query('SELECT * FROM ticket_status');
          $statusOptions = $stmt->fetchAll(PDO::FETCH_ASSOC); ?>
          <form action="../actions/action_change_status.php" method="post">
            <input type="hidden" name="ticket_id" value="<?= $ticket->getID() ?>">
            <label for="status">Change Status:</label>
            <select name="status" id="status">
              <?php foreach ($statusOptions as $statusOption) { ?>
                <option value="<?= $statusOption['status_id'] ?>"><?= $statusOption['status_name'] ?></option>
              <?php } ?>
            </select>
            <button type="submit">Update Status</button>
          </form>

          <form action="../actions/action_delete_ticket.php" method="post">
            <input type="hidden" name="ticket_id" value="<?= $ticket->getID() ?>">
            <button type="submit">Delete Ticket</button>
          </form>

        <?php } ?>
      </article>
    <?php } ?>
  </section>
  <script src="../javascript/filter_script.js"></script>
<?php } ?>

<?php function drawTicketsAgent(PDO $db, array $tickets, int $id, string $filter)
{ ?>
  <h2>Tickets</h2>
  <script src='../javascript/autocomplete.js'></script>

  <label for="filter">Order by:</label>

  <select id="filter" onchange="applyFilter(this.value)">
    <option value="recent" <?php echo ($filter === 'recent') ? 'selected' : ''; ?>>Recent</option>
    <option value="closed" <?php echo ($filter === 'closed') ? 'selected' : ''; ?>>Closed tickets</option>
    <option value="open" <?php echo ($filter === 'open') ? 'selected' : ''; ?>>Open tickets</option>
    <option value="title" <?php echo ($filter === 'title') ? 'selected' : ''; ?>>Title</option>
    <option value="department" <?php echo ($filter === 'department') ? 'selected' : ''; ?>>Department</option>
  </select>

  <section id="tickets">
    <?php foreach ($tickets as $ticket) { ?>
      <article>
        <a href="profile.php?username=<?= $ticket->getUsername() ?>"><?= $ticket->getUsername() ?></a>
        <h3><a href="ticket_page.php?id=<?= $ticket->getId() ?>"><?= $ticket->getTitle() ?></a></h3>
        <p><?= $ticket->getDescription() ?></p>
        <?php
        if (checkAdmin($db, $id)) { ?>
          <form action="../actions/action_delete_ticket.php" method="post">
            <input type="hidden" name="ticket_id" value="<?= $ticket->getId() ?>">
            <button type="submit">Delete Ticket</button>
          </form>
        <?php } ?>
      </article>
      <?php if (!($ticket->isAssigned($db))) { ?>
        <form action="../actions/action_assign_ticket.php">
          <input type="hidden" name="ticket_id" value="<?= $ticket->getId() ?>">
          <button type="submit">Assign Ticket to myself</button>
        </form>
        <?php if (isset($_SESSION['username_error'])): ?>
            <p class="error"><?= $_SESSION['username_error'] ?></p>
            <?php unset($_SESSION['username_error']); ?>
        <?php endif; ?>
        <form autocomplete="off" action="../actions/action_assign_ticket.php">
          <input type="text" id="username" name="username" autocomplete="off">
          <input type="hidden" name="ticket_id" value="<?= $ticket->getId() ?>">
          <button class="newticket" type="submit">Assign ticket to: </button>
        </form>
        <script>
          <?php
          $stmt = $db->query('SELECT username FROM clients JOIN agents ON client_id = agent_id');
          $agents = $stmt->fetchAll(PDO::FETCH_COLUMN);
          $agentsJson = json_encode($agents);
          ?>
          var agents = <?php echo $agentsJson; ?>;
          autocomplete(document.getElementById("username"), agents);
        </script>
      <?php } ?>
    <?php } ?>
    <script src="../javascript/agent_filter_script.js"></script>
  </section>
<?php } ?>

<?php function drawTicket(Ticket $ticket, PDO $db, Session $session)
{ ?>

  <article>
    <a href="profile.php?id=<?= $ticket->getClientId() ?>"><?= $ticket->getUsername() ?></a>
    <h3><?= $ticket->getTitle() ?></h3>
    <p><?= $ticket->getDescription() ?></p>
    <p><?= getDepartmentName($db, intval($ticket->getDepartmentId($db))) ?></p>
    <p><?= getStatusName($db, $ticket->getStatus($db)) ?></p>
    <?php
    $department = getDepartmentName($db, intval($ticket->getDepartmentId($db)));
    if (checkAgent($db, $session->getId())) { ?>
      <label for="department">Change Department:</label>
      <form action="../actions/action_alter_department.php" method="post">
        <select name="department">
          <?php
          $departments = getDepartments($db);
          foreach ($departments as $department) {
            $departmentId = $department['department_id'];
            $departmentName = $department['name'];
          ?>
            <option value="<?= $departmentId ?>"><?= $departmentName ?></option>
          <?php
          } ?>
        </select>
        <input type="hidden" name="ticket_id" value="<?= $ticket->getId() ?>">
        <input type="submit" value="Change department">
      </form><br>
      <?php
      $stmt = $db->query('SELECT * FROM ticket_status');
      $statusOptions = $stmt->fetchAll(PDO::FETCH_ASSOC); ?>
      <form action="../actions/action_change_status.php" method="post">
        <input type="hidden" name="ticket_id" value="<?= $ticket->getID() ?>">
        <label for="status">Change Status:</label>
        <select name="status" id="status">
          <?php foreach ($statusOptions as $statusOption) { ?>
            <option value="<?= $statusOption['status_id'] ?>"><?= $statusOption['status_name'] ?></option>
          <?php } ?>
        </select>
        <button type="submit">Update Status</button>
      </form>
    <?php } ?>
    <?php
    if (checkAdmin($db, $session->getId())) { ?>
      <form action="../actions/action_delete_ticket.php">
        <input type="hidden" name="ticket_id" value="<?= $ticket->getId() ?>">
        <button type="submit">Delete Ticket</button>
      </form>
    <?php }
    ?>
  </article>

  </html>
<?php } ?>

<?php function drawForms($db)
{ ?>
  <h1>Trouble ticket submission</h1>
  <form action="../actions/action_create_ticket.php" method="post">
    <label for="title">Title of the issue:</label>
    <input type="text" id="title" name="title" required><br><br>

    <label for="description">Description of the issue:</label>
    <textarea id="description" name="description" rows="5" cols="40" required></textarea><br><br>

    <label for="department">Choose a department to assign your ticket</label>
    <select name="department">
      <?php
      $departments = getDepartments($db);
      foreach ($departments as $department) {
        $departmentId = $department['department_id'];
        $departmentName = $department['name'];
      ?>
        <option value="<?= $departmentId ?>"><?= $departmentName ?></option>
      <?php
      } ?>
    </select><br><br>

    <input type="submit" value="Post trouble ticket">
  </form>
  </body>

  </html>
<?php } ?>
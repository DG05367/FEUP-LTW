PRAGMA foreign_keys = ON;

DROP TABLE IF EXISTS clients;
DROP TABLE IF EXISTS agents;
DROP TABLE IF EXISTS admins;
DROP TABLE IF EXISTS departments;
DROP TABLE IF EXISTS tickets;
DROP TABLE IF EXISTS comments;
DROP TABLE IF EXISTS tags;

CREATE TABLE departments (
  department_id INTEGER NOT NULL,
  name NVARCHAR(40) NOT NULL UNIQUE,
  PRIMARY KEY (department_id)
);

CREATE TABLE clients (
  client_id INTEGER NOT NULL,
  name NVARCHAR(40) NOT NULL,
  username NVARCHAR(20) NOT NULL UNIQUE,
  email NVARCHAR(40) NOT NULL UNIQUE,
  password NVARCHAR(40) NOT NULL,
  profile_picture NVARCHAR(255) DEFAULT '/public/images/profilepic.png',
  PRIMARY KEY (client_id)
);

CREATE TABLE agents (
  agent_id INTEGER NOT NULL,
  department_id INTEGER NOT NULL,
  PRIMARY KEY (agent_id),
  FOREIGN KEY (department_id) REFERENCES departments(department_id),
  FOREIGN KEY (agent_id) REFERENCES clients(client_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE admins (
  admin_id INTEGER NOT NULL,
  PRIMARY KEY (admin_id),
  FOREIGN KEY (admin_id) REFERENCES agents(agent_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE tickets (
  ticket_id INTEGER NOT NULL,
  client_id INTEGER NOT NULL,
  agent_id INTEGER,
  department_id INTEGER NOT NULL,
  title NVARCHAR(40) NOT NULL,
  description TEXT NOT NULL,
  status_id INTEGER NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (ticket_id),
  FOREIGN KEY (client_id) REFERENCES clients(client_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (agent_id) REFERENCES agents(agent_id),
  FOREIGN KEY (department_id) REFERENCES departments(department_id),
  FOREIGN KEY (status_id) REFERENCES ticket_status(status_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE ticket_status (
  status_id INTEGER NOT NULL,
  status_name NVARCHAR(20) NOT NULL UNIQUE,
  PRIMARY KEY (status_id)
);

CREATE TABLE tags (
  ticket_id INTEGER NOT NULL,
  tag NVARCHAR(20) NOT NULL,
  PRIMARY KEY (ticket_id, tag),
  FOREIGN KEY (ticket_id) REFERENCES tickets(ticket_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE comments (
  comment_id INTEGER NOT NULL,
  ticket_id INTEGER NOT NULL,
  agent_id INTEGER NOT NULL,
  comment TEXT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (comment_id),
  FOREIGN KEY (ticket_id) REFERENCES tickets(ticket_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (agent_id) REFERENCES agents(agent_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE faqs (
  faq_id INTEGER NOT NULL,
  question NVARCHAR(255) NOT NULL,
  answer TEXT NOT NULL,
  PRIMARY KEY (faq_id)
);
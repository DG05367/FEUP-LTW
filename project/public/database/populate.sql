INSERT INTO departments (department_id, name) VALUES
  (1, 'Sales'),
  (2, 'Support'),
  (3, 'Finance');

INSERT INTO clients (client_id, name, username, email, password) VALUES
  (1, 'John Doe', 'johndoe', 'johndoe@example.com', '$2y$10$uh2tWIllwpHfoY22.h4nEOL53Jr072oaEbirJPDZys6uUMXJr2bVu'), -- Decrypted: Testing123!
  (2, 'Jane Smith', 'janesmith', 'janesmith@example.com', '$2y$10$Quytv8skHyparjkewlosfenSdo8HkUqLvs3QVrrrkmSoMh/u0AHKi'), -- Decrypted: Abcd1234!
  (3, 'Mike Johnson', 'mikejohnson', 'mikejohnson@example.com', '$2y$10$x4ed00cXvmoLFd.n0wPj6.gOrru6/fZS615WUABhpWkFBWFXBpZHO'); -- Decrypted: Password1!

INSERT INTO agents (agent_id, department_id) VALUES
  (1, 1),
  (2, 2);

INSERT INTO admins (admin_id) VALUES
  (1);

INSERT INTO ticket_status (status_id, status_name) VALUES (1, 'Open');
INSERT INTO ticket_status (status_id, status_name) VALUES (2, 'In Progress');
INSERT INTO ticket_status (status_id, status_name) VALUES (3, 'Resolved');

INSERT INTO tickets (ticket_id, client_id, agent_id, department_id, title, description, status_id, created_at) VALUES
  (1, 1, 1, 1, 'Issue with product', 'I am facing an issue with the product.', 1, datetime('now')),
  (2, 2, 2, 2, 'Billing inquiry', 'I have a question about my billing.', 2, datetime('now')),
  (3, 3, 1, 1, 'Expense report', 'I need to submit an expense report.', 3, datetime('now'));

INSERT INTO tags (ticket_id, tag) VALUES
  (1, 'technical'),
  (1, 'urgent'),
  (2, 'billing'),
  (3, 'finance');

INSERT INTO comments (comment_id, ticket_id, agent_id, comment, created_at) VALUES
  (1, 1, 1, 'We apologize for the inconvenience. Our team is working on resolving the issue.', datetime('now')),
  (2, 1, 2, 'Please provide more details about the problem you are facing.', datetime('now')),
  (3, 2, 2, 'Your billing inquiry has been resolved. If you have any further questions, feel free to ask.', datetime('now'));

INSERT INTO FAQs (faq_id, question, answer) VALUES
  (1, 'What are the supported payment methods?', 'We support various payment methods such as credit cards, PayPal, and bank transfers.'),
  (2, 'How can I reset my password?', 'To reset your password, click on the "Forgot Password" link on the login page and follow the instructions provided.'),
  (3, 'How long does it take to receive a response to a support ticket?', 'We strive to respond to support tickets within 24 hours.');




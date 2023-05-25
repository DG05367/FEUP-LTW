rm -f database.db

sqlite3 -init database.sql database.db ".read populate.sql"
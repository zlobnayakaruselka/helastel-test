INSERT INTO test.book (id, name) VALUES (1, 'book_1');
INSERT INTO test.book (id, name) VALUES (2, 'book_2');
INSERT INTO test.book (id, name) VALUES (3, 'book_3');
INSERT INTO test.book (id, name) VALUES (4, 'book_4');
INSERT INTO test.book (id, name) VALUES (5, 'book_5');


INSERT INTO test.author (id, name) VALUES (1, 'author_1');
INSERT INTO test.author (id, name) VALUES (2, 'author_2');
INSERT INTO test.author (id, name) VALUES (3, 'author_3');
INSERT INTO test.author (id, name) VALUES (4, 'author_4');
INSERT INTO test.author (id, name) VALUES (5, 'author_5');

INSERT INTO test.authorship (book_id, author_id) VALUES (1, 2);
INSERT INTO test.authorship (book_id, author_id) VALUES (1, 3);
INSERT INTO test.authorship (book_id, author_id) VALUES (2, 1);
INSERT INTO test.authorship (book_id, author_id) VALUES (3, 3);
INSERT INTO test.authorship (book_id, author_id) VALUES (4, 5);
INSERT INTO test.authorship (book_id, author_id) VALUES (5, 4);

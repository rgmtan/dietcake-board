use board;

INSERT INTO thread SET title='Hello', created=NOW();
INSERT INTO comment SET thread_id=1, username='sakana-san', body='I am hungry', created=NOW();
INSERT INTO thread SET username='tester',title='Thread2', created=NOW();
drop table members;
drop table friends;
drop table likes;
drop table posts;
drop table responses;
drop table friend_applications;

CREATE TABLE friend_applications (
    id           INTEGER NOT NULL,
    members_id   INTEGER NOT NULL,
    object_id    INTEGER NOT NULL,
    status       VARCHAR2(10 CHAR) NOT NULL,
    delete_at    TIMESTAMP(8)
)
LOGGING;

ALTER TABLE friend_applications ADD CONSTRAINT friend_applications_pk PRIMARY KEY ( id );

ALTER TABLE friend_applications ADD CONSTRAINT friend_applications_object_id_un UNIQUE ( object_id );

CREATE TABLE friends (
    id           INTEGER NOT NULL,
    members_id   INTEGER NOT NULL,
    friend_id    INTEGER NOT NULL,
    create_at    DATE,
    update_at    TIMESTAMP(8),
    delete_at    TIMESTAMP(8)
)
LOGGING;

ALTER TABLE friends
    ADD CONSTRAINT friends_pk PRIMARY KEY ( id,
    members_id,
    friend_id );

CREATE TABLE likes (
    id             INTEGER NOT NULL,
    like_time      DATE,
    posts_id       INTEGER NOT NULL,
    responses_id   INTEGER NOT NULL,
    member_id      INTEGER,
    create_at      TIMESTAMP(8),
    update_at      TIMESTAMP(8),
    delete_at      TIMESTAMP(8)
)
LOGGING;

CREATE UNIQUE INDEX likes__idx ON
    likes ( posts_id ASC )
        LOGGING;

CREATE UNIQUE INDEX likes__idxv1 ON
    likes ( responses_id ASC )
        LOGGING;

ALTER TABLE likes ADD CONSTRAINT likes_pk PRIMARY KEY ( id );

CREATE TABLE members (
    id                 INTEGER NOT NULL,
    password           VARCHAR2(255 CHAR) NOT NULL,
    email              VARCHAR2(50 CHAR) NOT NULL,
    full_name          VARCHAR2(50 CHAR),
    birth              DATE,
    gender             VARCHAR2(10 CHAR),
    status             VARCHAR2(10 CHAR),
    location           VARCHAR2(255 CHAR),
    visibility_level   VARCHAR2(10 CHAR),
    create_at          TIMESTAMP(8),
    update_at          TIMESTAMP(8),
    delete_at          TIMESTAMP(8)
)
LOGGING;

ALTER TABLE members ADD CONSTRAINT members_pk PRIMARY KEY ( id );

ALTER TABLE members ADD CONSTRAINT members_email_un UNIQUE ( email );

CREATE TABLE posts (
    id           INTEGER NOT NULL,
    content      CLOB,
    members_id   INTEGER NOT NULL,
    create_at    TIMESTAMP(8),
    update_at    TIMESTAMP(8),
    delete_at    TIMESTAMP(8)
)
LOGGING;

ALTER TABLE posts ADD CONSTRAINT posts_pk PRIMARY KEY ( id );

CREATE TABLE responses (
    id                   INTEGER NOT NULL,
    posts_id             INTEGER NOT NULL,
    members_id           INTEGER NOT NULL,
    parent_response_id   INTEGER,
    create_at            TIMESTAMP(8),
    update_at            TIMESTAMP(8),
    delete_at            TIMESTAMP(8)
)
LOGGING;

ALTER TABLE responses ADD CONSTRAINT responses_pk PRIMARY KEY ( id );

ALTER TABLE friend_applications
    ADD CONSTRAINT friend_applications_members_fk FOREIGN KEY ( members_id )
        REFERENCES members ( id )
    NOT DEFERRABLE;

ALTER TABLE friends
    ADD CONSTRAINT friends_members_fk FOREIGN KEY ( members_id )
        REFERENCES members ( id )
    NOT DEFERRABLE;

ALTER TABLE likes
    ADD CONSTRAINT likes_posts_fk FOREIGN KEY ( posts_id )
        REFERENCES posts ( id )
    NOT DEFERRABLE;

ALTER TABLE likes
    ADD CONSTRAINT likes_responses_fk FOREIGN KEY ( responses_id )
        REFERENCES responses ( id )
    NOT DEFERRABLE;

ALTER TABLE posts
    ADD CONSTRAINT posts_members_fk FOREIGN KEY ( members_id )
        REFERENCES members ( id )
    NOT DEFERRABLE;

ALTER TABLE responses
    ADD CONSTRAINT responses_members_fk FOREIGN KEY ( members_id )
        REFERENCES members ( id )
    NOT DEFERRABLE;

ALTER TABLE responses
    ADD CONSTRAINT responses_posts_fk FOREIGN KEY ( posts_id )
        REFERENCES posts ( id )
    NOT DEFERRABLE;
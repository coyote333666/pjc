\connect "test";

/* SQL DDL */

CREATE SEQUENCE public.chat_message_seq
    START WITH 20
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

CREATE TABLE chat_message (
  chat_message_id integer NOT NULL,
  to_user_id integer NOT NULL,
  from_user_id integer NOT NULL,
  chat_message text NOT NULL,
  created_at timestamp WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL,
  status boolean NOT NULL
) ;

ALTER TABLE ONLY public.chat_message 
	ALTER COLUMN status SET DEFAULT false;

ALTER TABLE ONLY public.chat_message
    ADD CONSTRAINT chat_message_pk PRIMARY KEY (chat_message_id);

ALTER TABLE ONLY public.chat_message ALTER COLUMN chat_message_id SET DEFAULT nextval('public.chat_message_seq'::regclass);

CREATE SEQUENCE public.login_details_seq
    START WITH 20
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

CREATE TABLE login_details (
  login_details_id integer NOT NULL,
  user_id integer NOT NULL,
  last_activity timestamp WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL
);

ALTER TABLE ONLY public.login_details
    ADD CONSTRAINT login_details_pk PRIMARY KEY (login_details_id);

ALTER TABLE ONLY public.login_details 
	ALTER COLUMN login_details_id SET DEFAULT nextval('public.login_details_seq'::regclass);

CREATE SEQUENCE public.chat_user_seq
    START WITH 20
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

CREATE TABLE public.chat_user
( 
	user_id integer NOT NULL DEFAULT nextval('public.chat_user_seq'::regclass),
	last_name character varying(255) COLLATE pg_catalog."default",
	first_name character varying(255) COLLATE pg_catalog."default",
	email character varying(255) COLLATE pg_catalog."default",
    CONSTRAINT user_pk PRIMARY KEY (user_id),
    CONSTRAINT user_uk UNIQUE (email)
)
WITH (
    OIDS = FALSE
);

CREATE INDEX "chat_user.last_name"
    ON public.chat_user USING btree
    (upper(last_name::text) COLLATE pg_catalog."default" varchar_pattern_ops);

CREATE INDEX "chat_user.first_name"
    ON public.chat_user USING btree
    (upper(first_name::text) COLLATE pg_catalog."default" varchar_pattern_ops);

CREATE INDEX "chat_user.email"
    ON public.chat_user USING btree
    (upper(email::text) COLLATE pg_catalog."default" varchar_pattern_ops);


/* SQL DML */

INSERT INTO "portlet" ("portlet_id","header", "portlet_name") VALUES
(1,'Online users','portlet_99');

INSERT INTO "portlet_user" ("user_id","portlets_state", "portlets_left", "portlets_right") VALUES
(1,'{"portlet-content-99":1}','portlet_99','');

INSERT INTO "portlet_user" ("user_id","portlets_state", "portlets_left", "portlets_right") VALUES
(2,'{"portlet-content-99":1}','portlet_99','');

INSERT INTO "chat_user" ("user_id","last_name", "first_name", "email") VALUES
(1,'Smith','John','John-Smith@me.com');

INSERT INTO "chat_user" ("user_id","last_name", "first_name", "email") VALUES
(2,'Tremblay','Pierre','Pierre-Tremblay@me.com');


--
-- PostgreSQL database dump
--

-- Dumped from database version 13.2
-- Dumped by pg_dump version 13.2

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: collection; Type: TABLE; Schema: public; Owner: dev
--

CREATE TABLE public.collection (
    id integer NOT NULL,
    user_id integer NOT NULL,
    title character varying(255) NOT NULL,
    created_at integer NOT NULL,
    updated_at integer NOT NULL
);


ALTER TABLE public.collection OWNER TO dev;

--
-- Name: collection_id_seq; Type: SEQUENCE; Schema: public; Owner: dev
--

CREATE SEQUENCE public.collection_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.collection_id_seq OWNER TO dev;

--
-- Name: collection_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dev
--

ALTER SEQUENCE public.collection_id_seq OWNED BY public.collection.id;


--
-- Name: migration; Type: TABLE; Schema: public; Owner: dev
--

CREATE TABLE public.migration (
    version character varying(180) NOT NULL,
    apply_time integer
);


ALTER TABLE public.migration OWNER TO dev;

--
-- Name: photo; Type: TABLE; Schema: public; Owner: dev
--

CREATE TABLE public.photo (
    id integer NOT NULL,
    collection_id integer NOT NULL,
    photo_id character varying(20) NOT NULL,
    url character varying(255) NOT NULL,
    title character varying(255) NOT NULL,
    description text,
    created_at integer NOT NULL,
    updated_at integer NOT NULL
);


ALTER TABLE public.photo OWNER TO dev;

--
-- Name: photo_id_seq; Type: SEQUENCE; Schema: public; Owner: dev
--

CREATE SEQUENCE public.photo_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.photo_id_seq OWNER TO dev;

--
-- Name: photo_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dev
--

ALTER SEQUENCE public.photo_id_seq OWNED BY public.photo.id;


--
-- Name: user; Type: TABLE; Schema: public; Owner: dev
--

CREATE TABLE public."user" (
    id integer NOT NULL,
    username character varying(255) NOT NULL,
    auth_key character varying(32) NOT NULL,
    password_hash character varying(255) NOT NULL,
    password_reset_token character varying(255),
    email character varying(255) NOT NULL,
    status smallint DEFAULT 10 NOT NULL,
    created_at integer NOT NULL,
    updated_at integer NOT NULL,
    verification_token character varying(255) DEFAULT NULL::character varying,
    is_admin boolean DEFAULT false
);


ALTER TABLE public."user" OWNER TO dev;

--
-- Name: user_id_seq; Type: SEQUENCE; Schema: public; Owner: dev
--

CREATE SEQUENCE public.user_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.user_id_seq OWNER TO dev;

--
-- Name: user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dev
--

ALTER SEQUENCE public.user_id_seq OWNED BY public."user".id;


--
-- Name: collection id; Type: DEFAULT; Schema: public; Owner: dev
--

ALTER TABLE ONLY public.collection ALTER COLUMN id SET DEFAULT nextval('public.collection_id_seq'::regclass);


--
-- Name: photo id; Type: DEFAULT; Schema: public; Owner: dev
--

ALTER TABLE ONLY public.photo ALTER COLUMN id SET DEFAULT nextval('public.photo_id_seq'::regclass);


--
-- Name: user id; Type: DEFAULT; Schema: public; Owner: dev
--

ALTER TABLE ONLY public."user" ALTER COLUMN id SET DEFAULT nextval('public.user_id_seq'::regclass);


--
-- Data for Name: collection; Type: TABLE DATA; Schema: public; Owner: dev
--

COPY public.collection (id, user_id, title, created_at, updated_at) FROM stdin;
67	1	Dogs	1620395594	1620395594
\.


--
-- Data for Name: migration; Type: TABLE DATA; Schema: public; Owner: dev
--

COPY public.migration (version, apply_time) FROM stdin;
m000000_000000_base	1620042694
m130524_201442_init	1620042698
m190124_110200_add_verification_token_column_to_user_table	1620042698
m210427_133605_create_collection_table	1620042698
m210427_133619_create_photo_table	1620042698
m210428_205826_add_flag_admin_on_user_table	1620042698
\.


--
-- Data for Name: photo; Type: TABLE DATA; Schema: public; Owner: dev
--

COPY public.photo (id, collection_id, photo_id, url, title, description, created_at, updated_at) FROM stdin;
13	12	VtfiPvSGh5s	https://images.unsplash.com/photo-1597404294360-feeeda04612e?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwyMjQ2NTl8MHwxfGFsbHx8fHx8fHx8fDE2MjAxNjI5NTQ&ixlib=rb-1.2.1&q=80&w=400	Alan Flack	\N	1620162954	1620162954
14	12	aiwuLjLPFnU	https://images.unsplash.com/photo-1493238792000-8113da705763?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwyMjQ2NTl8MHwxfGFsbHx8fHx8fHx8fDE2MjAxNjI5NTk&ixlib=rb-1.2.1&q=80&w=400	Evgeny Tchebotarev	Road Warrior	1620162960	1620162960
15	12	ZRns2R5azu0	https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwyMjQ2NTl8MHwxfGFsbHx8fHx8fHx8fDE2MjAxNjI5NjU&ixlib=rb-1.2.1&q=80&w=400	Erik Mclean	\N	1620162965	1620162965
7	6	jbNnwi7L0Mg	https://images.unsplash.com/flagged/photo-1574967779066-61fb8aa1f7bf?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwyMjQ2NTl8MHwxfGFsbHx8fHx8fHx8fDE2MjAxNTQ5MDE&ixlib=rb-1.2.1&q=80&w=400	Mahdiasd 	Photo by Mahdi dsBafande	1620154902	1620219151
16	12	6mgYRkxG3oM	https://images.unsplash.com/photo-1620136619922-f592abb9df44?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwyMjQ2NTl8MHwxfGFsbHx8fHx8fHx8fDE2MjAyNDI2OTU&ixlib=rb-1.2.1&q=80&w=400	Annie Spratt	\N	1620242695	1620242695
17	67	6mgYRkxG3oM	https://images.unsplash.com/photo-1620136619922-f592abb9df44?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwyMjQ2NTl8MHwxfGFsbHx8fHx8fHx8fDE2MjAyNDI2OTU&ixlib=rb-1.2.1&q=80&w=400	Annie Spratt	\N	1620395607	1620395607
\.


--
-- Data for Name: user; Type: TABLE DATA; Schema: public; Owner: dev
--

COPY public."user" (id, username, auth_key, password_hash, password_reset_token, email, status, created_at, updated_at, verification_token, is_admin) FROM stdin;
1	Nicholls	u5zCDV-FVexGxk3rivi66KnTCnf1qOqW	$2y$13$mzJElbKxGMXv9Tb/bN318uNXd3WN4TZSc2axBtxdNmnp4JjPFjNcG	\N	nicoledesma36@gmail.com	10	1620396430	1620396438	btaT2vcvX4-_rMuv9tmzXfhChsWF7pkJ_1620396430	f
\.


--
-- Name: collection_id_seq; Type: SEQUENCE SET; Schema: public; Owner: dev
--

SELECT pg_catalog.setval('public.collection_id_seq', 71, true);


--
-- Name: photo_id_seq; Type: SEQUENCE SET; Schema: public; Owner: dev
--

SELECT pg_catalog.setval('public.photo_id_seq', 17, true);


--
-- Name: user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: dev
--

SELECT pg_catalog.setval('public.user_id_seq', 1, true);


--
-- Name: collection collection_pkey; Type: CONSTRAINT; Schema: public; Owner: dev
--

ALTER TABLE ONLY public.collection
    ADD CONSTRAINT collection_pkey PRIMARY KEY (id);


--
-- Name: migration migration_pkey; Type: CONSTRAINT; Schema: public; Owner: dev
--

ALTER TABLE ONLY public.migration
    ADD CONSTRAINT migration_pkey PRIMARY KEY (version);


--
-- Name: photo photo_pkey; Type: CONSTRAINT; Schema: public; Owner: dev
--

ALTER TABLE ONLY public.photo
    ADD CONSTRAINT photo_pkey PRIMARY KEY (id);


--
-- Name: user user_email_key; Type: CONSTRAINT; Schema: public; Owner: dev
--

ALTER TABLE ONLY public."user"
    ADD CONSTRAINT user_email_key UNIQUE (email);


--
-- Name: user user_password_reset_token_key; Type: CONSTRAINT; Schema: public; Owner: dev
--

ALTER TABLE ONLY public."user"
    ADD CONSTRAINT user_password_reset_token_key UNIQUE (password_reset_token);


--
-- Name: user user_pkey; Type: CONSTRAINT; Schema: public; Owner: dev
--

ALTER TABLE ONLY public."user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (id);


--
-- Name: user user_username_key; Type: CONSTRAINT; Schema: public; Owner: dev
--

ALTER TABLE ONLY public."user"
    ADD CONSTRAINT user_username_key UNIQUE (username);


--
-- Name: idx-collection-user_id; Type: INDEX; Schema: public; Owner: dev
--

CREATE INDEX "idx-collection-user_id" ON public.collection USING btree (user_id);


--
-- Name: idx-photo-collection_id; Type: INDEX; Schema: public; Owner: dev
--

CREATE INDEX "idx-photo-collection_id" ON public.photo USING btree (collection_id);


--
-- Name: collection fk-collection-user_id; Type: FK CONSTRAINT; Schema: public; Owner: dev
--

ALTER TABLE ONLY public.collection
    ADD CONSTRAINT "fk-collection-user_id" FOREIGN KEY (user_id) REFERENCES public."user"(id) ON DELETE CASCADE;


--
-- Name: photo fk-photo-collection_id; Type: FK CONSTRAINT; Schema: public; Owner: dev
--

ALTER TABLE ONLY public.photo
    ADD CONSTRAINT "fk-photo-collection_id" FOREIGN KEY (collection_id) REFERENCES public.collection(id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--


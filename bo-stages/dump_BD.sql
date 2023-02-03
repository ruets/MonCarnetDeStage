--
-- PostgreSQL database dump
--

-- Dumped from database version 15.1
-- Dumped by pg_dump version 15.1

-- Started on 2023-01-25 12:19:31

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

--
-- TOC entry 237 (class 1255 OID 16419)
-- Name: notify_messenger_messages(); Type: FUNCTION; Schema: public; Owner: app-stages
--

CREATE FUNCTION public.notify_messenger_messages() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
            BEGIN
                PERFORM pg_notify('messenger_messages', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$;


ALTER FUNCTION public.notify_messenger_messages() OWNER TO "app-stages";

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 234 (class 1259 OID 16577)
-- Name: candidature; Type: TABLE; Schema: public; Owner: app-stages
--

CREATE TABLE public.candidature (
    id integer NOT NULL,
    compte_etudiant_id integer NOT NULL,
    offre_id integer NOT NULL,
    etat_candidature_id integer NOT NULL,
    type_action character varying(255) DEFAULT NULL::character varying,
    date_action timestamp(0) without time zone NOT NULL
);


ALTER TABLE public.candidature OWNER TO "app-stages";

--
-- TOC entry 231 (class 1259 OID 16574)
-- Name: candidature_id_seq; Type: SEQUENCE; Schema: public; Owner: app-stages
--

CREATE SEQUENCE public.candidature_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.candidature_id_seq OWNER TO "app-stages";

--
-- TOC entry 223 (class 1259 OID 16436)
-- Name: compte_etudiant; Type: TABLE; Schema: public; Owner: app-stages
--

CREATE TABLE public.compte_etudiant (
    id integer NOT NULL,
    etat_recherche_id integer NOT NULL,
    login character varying(180) NOT NULL,
    roles json NOT NULL,
    password character varying(255) NOT NULL,
    parcours character varying(1) NOT NULL,
    derniere_connexion timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    etudiant_id integer NOT NULL
);


ALTER TABLE public.compte_etudiant OWNER TO "app-stages";

--
-- TOC entry 216 (class 1259 OID 16421)
-- Name: compte_etudiant_id_seq; Type: SEQUENCE; Schema: public; Owner: app-stages
--

CREATE SEQUENCE public.compte_etudiant_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.compte_etudiant_id_seq OWNER TO "app-stages";

--
-- TOC entry 230 (class 1259 OID 16567)
-- Name: doctrine_migration_versions; Type: TABLE; Schema: public; Owner: app-stages
--

CREATE TABLE public.doctrine_migration_versions (
    version character varying(191) NOT NULL,
    executed_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    execution_time integer
);


ALTER TABLE public.doctrine_migration_versions OWNER TO "app-stages";

--
-- TOC entry 224 (class 1259 OID 16446)
-- Name: entreprise; Type: TABLE; Schema: public; Owner: app-stages
--

CREATE TABLE public.entreprise (
    id integer NOT NULL,
    raison_sociale character varying(255) NOT NULL,
    ville character varying(255) NOT NULL,
    pays character varying(255) DEFAULT NULL::character varying
);


ALTER TABLE public.entreprise OWNER TO "app-stages";

--
-- TOC entry 217 (class 1259 OID 16422)
-- Name: entreprise_id_seq; Type: SEQUENCE; Schema: public; Owner: app-stages
--

CREATE SEQUENCE public.entreprise_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.entreprise_id_seq OWNER TO "app-stages";

--
-- TOC entry 225 (class 1259 OID 16454)
-- Name: etat_candidature; Type: TABLE; Schema: public; Owner: app-stages
--

CREATE TABLE public.etat_candidature (
    id integer NOT NULL,
    etat character varying(255) NOT NULL,
    descriptif text
);


ALTER TABLE public.etat_candidature OWNER TO "app-stages";

--
-- TOC entry 218 (class 1259 OID 16423)
-- Name: etat_candidature_id_seq; Type: SEQUENCE; Schema: public; Owner: app-stages
--

CREATE SEQUENCE public.etat_candidature_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.etat_candidature_id_seq OWNER TO "app-stages";

--
-- TOC entry 226 (class 1259 OID 16461)
-- Name: etat_offre; Type: TABLE; Schema: public; Owner: app-stages
--

CREATE TABLE public.etat_offre (
    id integer NOT NULL,
    etat character varying(255) NOT NULL,
    descriptif text
);


ALTER TABLE public.etat_offre OWNER TO "app-stages";

--
-- TOC entry 219 (class 1259 OID 16424)
-- Name: etat_offre_id_seq; Type: SEQUENCE; Schema: public; Owner: app-stages
--

CREATE SEQUENCE public.etat_offre_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.etat_offre_id_seq OWNER TO "app-stages";

--
-- TOC entry 227 (class 1259 OID 16468)
-- Name: etat_recherche; Type: TABLE; Schema: public; Owner: app-stages
--

CREATE TABLE public.etat_recherche (
    id integer NOT NULL,
    etat character varying(255) NOT NULL,
    descriptif text
);


ALTER TABLE public.etat_recherche OWNER TO "app-stages";

--
-- TOC entry 220 (class 1259 OID 16425)
-- Name: etat_recherche_id_seq; Type: SEQUENCE; Schema: public; Owner: app-stages
--

CREATE SEQUENCE public.etat_recherche_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.etat_recherche_id_seq OWNER TO "app-stages";

--
-- TOC entry 228 (class 1259 OID 16475)
-- Name: etudiant; Type: TABLE; Schema: public; Owner: app-stages
--

CREATE TABLE public.etudiant (
    id integer NOT NULL,
    numero_ine character varying(11) NOT NULL,
    nom character varying(255) NOT NULL,
    prenom character varying(255) NOT NULL,
    email character varying(255) NOT NULL
);


ALTER TABLE public.etudiant OWNER TO "app-stages";

--
-- TOC entry 221 (class 1259 OID 16426)
-- Name: etudiant_id_seq; Type: SEQUENCE; Schema: public; Owner: app-stages
--

CREATE SEQUENCE public.etudiant_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.etudiant_id_seq OWNER TO "app-stages";

--
-- TOC entry 215 (class 1259 OID 16407)
-- Name: messenger_messages; Type: TABLE; Schema: public; Owner: app-stages
--

CREATE TABLE public.messenger_messages (
    id bigint NOT NULL,
    body text NOT NULL,
    headers text NOT NULL,
    queue_name character varying(190) NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    available_at timestamp(0) without time zone NOT NULL,
    delivered_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone
);


ALTER TABLE public.messenger_messages OWNER TO "app-stages";

--
-- TOC entry 214 (class 1259 OID 16406)
-- Name: messenger_messages_id_seq; Type: SEQUENCE; Schema: public; Owner: app-stages
--

CREATE SEQUENCE public.messenger_messages_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.messenger_messages_id_seq OWNER TO "app-stages";

--
-- TOC entry 3458 (class 0 OID 0)
-- Dependencies: 214
-- Name: messenger_messages_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: app-stages
--

ALTER SEQUENCE public.messenger_messages_id_seq OWNED BY public.messenger_messages.id;


--
-- TOC entry 229 (class 1259 OID 16482)
-- Name: offre; Type: TABLE; Schema: public; Owner: app-stages
--

CREATE TABLE public.offre (
    id integer NOT NULL,
    etat_offre_id integer NOT NULL,
    entreprise_id integer NOT NULL,
    intitule character varying(255) NOT NULL,
    descriptif text,
    date_depot date NOT NULL,
    parcours character varying(1) DEFAULT NULL::character varying,
    mots_cles character varying(255) DEFAULT NULL::character varying,
    url_piece_jointe character varying(2000) DEFAULT NULL::character varying
);


ALTER TABLE public.offre OWNER TO "app-stages";

--
-- TOC entry 235 (class 1259 OID 16586)
-- Name: offre_consultee; Type: TABLE; Schema: public; Owner: app-stages
--

CREATE TABLE public.offre_consultee (
    id integer NOT NULL,
    compte_etudiant_id integer NOT NULL,
    offre_id integer NOT NULL
);


ALTER TABLE public.offre_consultee OWNER TO "app-stages";

--
-- TOC entry 232 (class 1259 OID 16575)
-- Name: offre_consultee_id_seq; Type: SEQUENCE; Schema: public; Owner: app-stages
--

CREATE SEQUENCE public.offre_consultee_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.offre_consultee_id_seq OWNER TO "app-stages";

--
-- TOC entry 222 (class 1259 OID 16427)
-- Name: offre_id_seq; Type: SEQUENCE; Schema: public; Owner: app-stages
--

CREATE SEQUENCE public.offre_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.offre_id_seq OWNER TO "app-stages";

--
-- TOC entry 236 (class 1259 OID 16593)
-- Name: offre_retenue; Type: TABLE; Schema: public; Owner: app-stages
--

CREATE TABLE public.offre_retenue (
    id integer NOT NULL,
    compte_etudiant_id integer NOT NULL,
    offre_id integer NOT NULL
);


ALTER TABLE public.offre_retenue OWNER TO "app-stages";

--
-- TOC entry 233 (class 1259 OID 16576)
-- Name: offre_retenue_id_seq; Type: SEQUENCE; Schema: public; Owner: app-stages
--

CREATE SEQUENCE public.offre_retenue_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.offre_retenue_id_seq OWNER TO "app-stages";

--
-- TOC entry 3228 (class 2604 OID 16410)
-- Name: messenger_messages id; Type: DEFAULT; Schema: public; Owner: app-stages
--

ALTER TABLE ONLY public.messenger_messages ALTER COLUMN id SET DEFAULT nextval('public.messenger_messages_id_seq'::regclass);


--
-- TOC entry 3450 (class 0 OID 16577)
-- Dependencies: 234
-- Data for Name: candidature; Type: TABLE DATA; Schema: public; Owner: app-stages
--

COPY public.candidature (id, compte_etudiant_id, offre_id, etat_candidature_id, type_action, date_action) FROM stdin;
1	2	10	6	Envoyé CV+LM par mail au responsable du stage	2023-01-20 17:34:36
3	3	11	2	Candidature envoyée par courrier (CV+LM)	2023-01-22 10:46:09
5	5	12	4	Envoi CV+LM, prise de contacte au tél.	2023-01-25 11:02:23
\.


--
-- TOC entry 3439 (class 0 OID 16436)
-- Dependencies: 223
-- Data for Name: compte_etudiant; Type: TABLE DATA; Schema: public; Owner: app-stages
--

COPY public.compte_etudiant (id, etat_recherche_id, login, roles, password, parcours, derniere_connexion, etudiant_id) FROM stdin;
1	1	fontenae	["ROLE_ADMIN"]	$2y$13$HQpMH5Kd0wsAzUQcBCOHu.kDUgunJliBA44tK/gNHAgoDQ.qAQx2i	*	\N	1
2	4	khonnual	["ROLE_ETUDIANT"]	$2y$13$DY37MaTjWxmJ3aYeA4qB3O2DXgUlLJgR4VzBXHNsTFRTQAcu.1Q6S	A	\N	2
3	3	enfaitme	["ROLE_ETUDIANT"]	$2y$13$a3HbRV0XGnZveyTikYO5RO5EFTC.5dkBo6WkhHttgQ5jGYaVz7vB.	B	\N	3
4	2	herbienj	["ROLE_ETUDIANT"]	$2y$13$VcZ6aBpYos81LWZFh0.F0Ovz9D6f3G1CvF5XONddV8y8oNPiJXmne	A	\N	4
5	3	borealea	["ROLE_ETUDIANT"]	$2y$13$WGEjYD.WdJ6MdYYupl1qF.l0AguuY3hTQyg/3zAoVpM4.mbltqeYS	B	\N	5
11	1	haplutaj	["ROLE_ETUDIANT"]	$2y$13$YjO.PIUqu79nkh0z38sItuxiWuSNv.9WAB1s0YgK1vqk6LzplFzCO	A	\N	10
\.


--
-- TOC entry 3446 (class 0 OID 16567)
-- Dependencies: 230
-- Data for Name: doctrine_migration_versions; Type: TABLE DATA; Schema: public; Owner: app-stages
--

COPY public.doctrine_migration_versions (version, executed_at, execution_time) FROM stdin;
\.


--
-- TOC entry 3440 (class 0 OID 16446)
-- Dependencies: 224
-- Data for Name: entreprise; Type: TABLE DATA; Schema: public; Owner: app-stages
--

COPY public.entreprise (id, raison_sociale, ville, pays) FROM stdin;
2	Reckonect SAS	Grenoble	France
3	Khrone SAS	Romans	France
4	Framatome	Ugine	France
5	Association Championnet	Sallanches	France
6	Creative VR3D	Cannes	France
7	Parker Lord	Pont de l'Isère	France
8	INCOM	Gières	France
9	LIG	Saint Martin d'Hères	France
10	LYNRED	Veurey-Voroize	France
11	ELYXOFT	Gillonay	France
12	INSIDIX SAS	Seyssins	France
13	HARDIS	Seyssinet-Pariset	France
\.


--
-- TOC entry 3441 (class 0 OID 16454)
-- Dependencies: 225
-- Data for Name: etat_candidature; Type: TABLE DATA; Schema: public; Owner: app-stages
--

COPY public.etat_candidature (id, etat, descriptif) FROM stdin;
2	Attente Réponse	L'étudiant·e a envoyé sa candidature mais n'a pas encore obtenu de réponse
5	Attente Entretien	L'étudiant·e a obtenu une date de RDV et attend que celui-ci soit réalisé
4	Attente RDV	L'étudiant·e a obtenu une réponse positive à sa candidature et attend une date de RDV
6	Acceptée	L'étudiant·e a obtenu une réponse positive à sa candidature à l'issue du RDV
1	A Envoyer	L'étudiant·e a retenu l'offre de stage mais n'y a pas encore candidaté
3	Refusée	L'étudiant·e a obtenu une réponse négative à sa candidature
\.


--
-- TOC entry 3442 (class 0 OID 16461)
-- Dependencies: 226
-- Data for Name: etat_offre; Type: TABLE DATA; Schema: public; Owner: app-stages
--

COPY public.etat_offre (id, etat, descriptif) FROM stdin;
1	Disponible	L'offre est disponible : il est possible d'y candidater
2	Pourvue	L'offre n'est plus disponible, un·e étudiant·e l'a déjà prise : inutile d'y candidater
3	Expirée	L'offre est ancienne et n'est plus disponible : inutile d'y candidater
\.


--
-- TOC entry 3443 (class 0 OID 16468)
-- Dependencies: 227
-- Data for Name: etat_recherche; Type: TABLE DATA; Schema: public; Owner: app-stages
--

COPY public.etat_recherche (id, etat, descriptif) FROM stdin;
1	A Commencer	L'étudiant·e n'a pas encore consulté les offres de stage
2	Consultation	L'étudiant·e a commencé à consulter les offres de stage mais n'a pas encore candidaté
3	Candidature	L'étudiant·e a fait une ou plusieurs candidatures, il·elle attend encore des réponses
4	Terminée	L'étudiant·e a trouvé un stage, sa recherche est terminée
\.


--
-- TOC entry 3444 (class 0 OID 16475)
-- Dependencies: 228
-- Data for Name: etudiant; Type: TABLE DATA; Schema: public; Owner: app-stages
--

COPY public.etudiant (id, numero_ine, nom, prenom, email) FROM stdin;
1	0123456789A	FONTENAS	Eric	eric.fontenas@univ-grenoble-alpes.fr
2	9876543210B	KHONNU	Alain	alain.khonnu@iut2.fr
4	3456789012D	HERBIEN	Jean-Philippe	jean-philippe.herbien@iut2.fr
5	4567890123E	BOREALE	Aurore	aurore.boreale@iut2.fr
3	2345678901C	ENFAÏTE	Mélusine	melusine.enfaite@iut2.fr
10	5678901234F	HAPLUTARD	Jérémy	jeremy.haplutard@iut2.fr
\.


--
-- TOC entry 3431 (class 0 OID 16407)
-- Dependencies: 215
-- Data for Name: messenger_messages; Type: TABLE DATA; Schema: public; Owner: app-stages
--

COPY public.messenger_messages (id, body, headers, queue_name, created_at, available_at, delivered_at) FROM stdin;
\.


--
-- TOC entry 3445 (class 0 OID 16482)
-- Dependencies: 229
-- Data for Name: offre; Type: TABLE DATA; Schema: public; Owner: app-stages
--

COPY public.offre (id, etat_offre_id, entreprise_id, intitule, descriptif, date_depot, parcours, mots_cles, url_piece_jointe) FROM stdin;
9	1	10	SQL / PYTHON SQL*serveur, SSRS/ POWER BI, analyse de données	\N	2023-01-13	*	SQL; PYTHON; SQL server; SSRS; POWER BI; analyse de données	https://chamilo.iut2.univ-grenoble-alpes.fr/courses/INFO4012/document/Offres-de-stage-2022-2023/Fiche-proposition-stage_BILYNRED.pdf?cidReq=INFO4012&id_session=0&gidReq=0&gradebook=0&origin=
10	2	11	Développement d’application Android, GIT, Kotlin	\N	2023-01-10	A	Android; GIT; Kotlin	https://chamilo.iut2.univ-grenoble-alpes.fr/courses/INFO4012/document/Offres-de-stage-2022-2023/Fiche-proposition-stage-Elyxoft.pdf?cidReq=INFO4012&id_session=0&gidReq=0&gradebook=0&origin=
2	1	3	JS/PHP/Windows/Linux/Git, ERP	\N	2023-01-17	A	JS; PHP; Windows; Linux; Git; ERP	https://chamilo.iut2.univ-grenoble-alpes.fr/main/document/showinframes.php?cidReq=INFO4012&id_session=0&gidReq=0&gradebook=0&origin=&id=530018
11	1	12	Administration des Systèmes et Réseaux, configuation serveur Linux	\N	2023-01-10	B	administration; système; réseaux; linux	https://chamilo.iut2.univ-grenoble-alpes.fr/courses/INFO4012/document/Offres-de-stage-2022-2023/Fiche-proposition-stage-Insidix-2023.pdf?cidReq=INFO4012&id_session=0&gidReq=0&gradebook=0&origin=
12	1	13	Développement d’outils internes, Python, SQL	\N	2022-10-25	B	python; sql	https://chamilo.iut2.univ-grenoble-alpes.fr/courses/INFO4012/document/Offres-de-stage-2022-2023/Fiche-proposition-stage-IUT2-avril-2023-Hardis.pdf?cidReq=INFO4012&id_session=0&gidReq=0&gradebook=0&origin=
1	1	2	Développement web, full stack, Python, Javascript, Framework ReactJS, Angular, Symphony, D3JS, cytoscapeJS, ajax/flask, mongoDB	\N	2022-10-03	A	full stack; Python; JS; ReactJS; Angular; Symphony; D3JS; cytoscapeJS; ajax; flask; mongoDB	https://chamilo.iut2.univ-grenoble-alpes.fr/courses/INFO4012/document/Offres-de-stage-2022-2023/Fiche-Proposition-de-stage-Reckonect-SAS-Dev-Web.pdf?cidReq=INFO4012&id_session=0&gidReq=0&gradebook=0&origin=
3	1	4	C# et VB, tests de non-régression	\N	2022-10-19	*	C#; VB; tests; non-régression	https://chamilo.iut2.univ-grenoble-alpes.fr/main/document/showinframes.php?cidReq=INFO4012&id_session=0&gidReq=0&gradebook=0&origin=&id=506658
5	1	6	CSHarp Jeux UNITY 3D, développement	\N	2023-01-15	A	C#; UNITY; 3D	https://chamilo.iut2.univ-grenoble-alpes.fr/main/document/showinframes.php?cidReq=INFO4012&id_session=0&gidReq=0&gradebook=0&origin=&id=528808
4	1	5	Architecture Sharepoint, migration, conception	\N	2023-01-10	B	sharepoint; migration	https://chamilo.iut2.univ-grenoble-alpes.fr/main/document/showinframes.php?cidReq=INFO4012&id_session=0&gidReq=0&gradebook=0&origin=&id=527923
6	1	7	Tests fonctionnels, Panther, PHP8, Mysql	\N	2023-01-12	A	tests; Panther; PHP8; MySql	https://chamilo.iut2.univ-grenoble-alpes.fr/main/document/showinframes.php?cidReq=INFO4012&id_session=0&gidReq=0&gradebook=0&origin=&id=528711
7	1	8	Linux debian/centos, scripting bash, office, zabbix, logiciel de monitoring	\N	2023-01-17	B	Linux; debian; centos; scripting; bash; office; zabbix; monitoring	https://chamilo.iut2.univ-grenoble-alpes.fr/main/document/showinframes.php?cidReq=INFO4012&id_session=0&gidReq=0&gradebook=0&origin=&id=530017
8	1	9	Site web	\N	2023-01-13	A	web	https://chamilo.iut2.univ-grenoble-alpes.fr/main/document/showinframes.php?cidReq=INFO4012&id_session=0&gidReq=0&gradebook=0&origin=&id=529237
\.


--
-- TOC entry 3451 (class 0 OID 16586)
-- Dependencies: 235
-- Data for Name: offre_consultee; Type: TABLE DATA; Schema: public; Owner: app-stages
--

COPY public.offre_consultee (id, compte_etudiant_id, offre_id) FROM stdin;
1	2	10
2	2	5
3	3	11
5	5	4
6	5	12
8	2	2
9	2	8
10	2	6
11	3	4
12	4	1
\.


--
-- TOC entry 3452 (class 0 OID 16593)
-- Dependencies: 236
-- Data for Name: offre_retenue; Type: TABLE DATA; Schema: public; Owner: app-stages
--

COPY public.offre_retenue (id, compte_etudiant_id, offre_id) FROM stdin;
1	2	10
2	3	11
4	5	12
\.


--
-- TOC entry 3459 (class 0 OID 0)
-- Dependencies: 231
-- Name: candidature_id_seq; Type: SEQUENCE SET; Schema: public; Owner: app-stages
--

SELECT pg_catalog.setval('public.candidature_id_seq', 5, true);


--
-- TOC entry 3460 (class 0 OID 0)
-- Dependencies: 216
-- Name: compte_etudiant_id_seq; Type: SEQUENCE SET; Schema: public; Owner: app-stages
--

SELECT pg_catalog.setval('public.compte_etudiant_id_seq', 11, true);


--
-- TOC entry 3461 (class 0 OID 0)
-- Dependencies: 217
-- Name: entreprise_id_seq; Type: SEQUENCE SET; Schema: public; Owner: app-stages
--

SELECT pg_catalog.setval('public.entreprise_id_seq', 14, true);


--
-- TOC entry 3462 (class 0 OID 0)
-- Dependencies: 218
-- Name: etat_candidature_id_seq; Type: SEQUENCE SET; Schema: public; Owner: app-stages
--

SELECT pg_catalog.setval('public.etat_candidature_id_seq', 6, true);


--
-- TOC entry 3463 (class 0 OID 0)
-- Dependencies: 219
-- Name: etat_offre_id_seq; Type: SEQUENCE SET; Schema: public; Owner: app-stages
--

SELECT pg_catalog.setval('public.etat_offre_id_seq', 3, true);


--
-- TOC entry 3464 (class 0 OID 0)
-- Dependencies: 220
-- Name: etat_recherche_id_seq; Type: SEQUENCE SET; Schema: public; Owner: app-stages
--

SELECT pg_catalog.setval('public.etat_recherche_id_seq', 4, true);


--
-- TOC entry 3465 (class 0 OID 0)
-- Dependencies: 221
-- Name: etudiant_id_seq; Type: SEQUENCE SET; Schema: public; Owner: app-stages
--

SELECT pg_catalog.setval('public.etudiant_id_seq', 10, true);


--
-- TOC entry 3466 (class 0 OID 0)
-- Dependencies: 214
-- Name: messenger_messages_id_seq; Type: SEQUENCE SET; Schema: public; Owner: app-stages
--

SELECT pg_catalog.setval('public.messenger_messages_id_seq', 1, false);


--
-- TOC entry 3467 (class 0 OID 0)
-- Dependencies: 232
-- Name: offre_consultee_id_seq; Type: SEQUENCE SET; Schema: public; Owner: app-stages
--

SELECT pg_catalog.setval('public.offre_consultee_id_seq', 12, true);


--
-- TOC entry 3468 (class 0 OID 0)
-- Dependencies: 222
-- Name: offre_id_seq; Type: SEQUENCE SET; Schema: public; Owner: app-stages
--

SELECT pg_catalog.setval('public.offre_id_seq', 14, true);


--
-- TOC entry 3469 (class 0 OID 0)
-- Dependencies: 233
-- Name: offre_retenue_id_seq; Type: SEQUENCE SET; Schema: public; Owner: app-stages
--

SELECT pg_catalog.setval('public.offre_retenue_id_seq', 4, true);


--
-- TOC entry 3264 (class 2606 OID 16582)
-- Name: candidature candidature_pkey; Type: CONSTRAINT; Schema: public; Owner: app-stages
--

ALTER TABLE ONLY public.candidature
    ADD CONSTRAINT candidature_pkey PRIMARY KEY (id);


--
-- TOC entry 3243 (class 2606 OID 16443)
-- Name: compte_etudiant compte_etudiant_pkey; Type: CONSTRAINT; Schema: public; Owner: app-stages
--

ALTER TABLE ONLY public.compte_etudiant
    ADD CONSTRAINT compte_etudiant_pkey PRIMARY KEY (id);


--
-- TOC entry 3262 (class 2606 OID 16572)
-- Name: doctrine_migration_versions doctrine_migration_versions_pkey; Type: CONSTRAINT; Schema: public; Owner: app-stages
--

ALTER TABLE ONLY public.doctrine_migration_versions
    ADD CONSTRAINT doctrine_migration_versions_pkey PRIMARY KEY (version);


--
-- TOC entry 3248 (class 2606 OID 16453)
-- Name: entreprise entreprise_pkey; Type: CONSTRAINT; Schema: public; Owner: app-stages
--

ALTER TABLE ONLY public.entreprise
    ADD CONSTRAINT entreprise_pkey PRIMARY KEY (id);


--
-- TOC entry 3250 (class 2606 OID 16460)
-- Name: etat_candidature etat_candidature_pkey; Type: CONSTRAINT; Schema: public; Owner: app-stages
--

ALTER TABLE ONLY public.etat_candidature
    ADD CONSTRAINT etat_candidature_pkey PRIMARY KEY (id);


--
-- TOC entry 3252 (class 2606 OID 16467)
-- Name: etat_offre etat_offre_pkey; Type: CONSTRAINT; Schema: public; Owner: app-stages
--

ALTER TABLE ONLY public.etat_offre
    ADD CONSTRAINT etat_offre_pkey PRIMARY KEY (id);


--
-- TOC entry 3254 (class 2606 OID 16474)
-- Name: etat_recherche etat_recherche_pkey; Type: CONSTRAINT; Schema: public; Owner: app-stages
--

ALTER TABLE ONLY public.etat_recherche
    ADD CONSTRAINT etat_recherche_pkey PRIMARY KEY (id);


--
-- TOC entry 3256 (class 2606 OID 16481)
-- Name: etudiant etudiant_pkey; Type: CONSTRAINT; Schema: public; Owner: app-stages
--

ALTER TABLE ONLY public.etudiant
    ADD CONSTRAINT etudiant_pkey PRIMARY KEY (id);


--
-- TOC entry 3241 (class 2606 OID 16415)
-- Name: messenger_messages messenger_messages_pkey; Type: CONSTRAINT; Schema: public; Owner: app-stages
--

ALTER TABLE ONLY public.messenger_messages
    ADD CONSTRAINT messenger_messages_pkey PRIMARY KEY (id);


--
-- TOC entry 3271 (class 2606 OID 16590)
-- Name: offre_consultee offre_consultee_pkey; Type: CONSTRAINT; Schema: public; Owner: app-stages
--

ALTER TABLE ONLY public.offre_consultee
    ADD CONSTRAINT offre_consultee_pkey PRIMARY KEY (id);


--
-- TOC entry 3260 (class 2606 OID 16491)
-- Name: offre offre_pkey; Type: CONSTRAINT; Schema: public; Owner: app-stages
--

ALTER TABLE ONLY public.offre
    ADD CONSTRAINT offre_pkey PRIMARY KEY (id);


--
-- TOC entry 3275 (class 2606 OID 16597)
-- Name: offre_retenue offre_retenue_pkey; Type: CONSTRAINT; Schema: public; Owner: app-stages
--

ALTER TABLE ONLY public.offre_retenue
    ADD CONSTRAINT offre_retenue_pkey PRIMARY KEY (id);


--
-- TOC entry 3272 (class 1259 OID 16599)
-- Name: idx_3f0a4cc54cc8505a; Type: INDEX; Schema: public; Owner: app-stages
--

CREATE INDEX idx_3f0a4cc54cc8505a ON public.offre_retenue USING btree (offre_id);


--
-- TOC entry 3273 (class 1259 OID 16598)
-- Name: idx_3f0a4cc5f1fb3bf7; Type: INDEX; Schema: public; Owner: app-stages
--

CREATE INDEX idx_3f0a4cc5f1fb3bf7 ON public.offre_retenue USING btree (compte_etudiant_id);


--
-- TOC entry 3237 (class 1259 OID 16418)
-- Name: idx_75ea56e016ba31db; Type: INDEX; Schema: public; Owner: app-stages
--

CREATE INDEX idx_75ea56e016ba31db ON public.messenger_messages USING btree (delivered_at);


--
-- TOC entry 3238 (class 1259 OID 16417)
-- Name: idx_75ea56e0e3bd61ce; Type: INDEX; Schema: public; Owner: app-stages
--

CREATE INDEX idx_75ea56e0e3bd61ce ON public.messenger_messages USING btree (available_at);


--
-- TOC entry 3239 (class 1259 OID 16416)
-- Name: idx_75ea56e0fb7336f0; Type: INDEX; Schema: public; Owner: app-stages
--

CREATE INDEX idx_75ea56e0fb7336f0 ON public.messenger_messages USING btree (queue_name);


--
-- TOC entry 3257 (class 1259 OID 16493)
-- Name: idx_af86866fa4aeafea; Type: INDEX; Schema: public; Owner: app-stages
--

CREATE INDEX idx_af86866fa4aeafea ON public.offre USING btree (entreprise_id);


--
-- TOC entry 3258 (class 1259 OID 16492)
-- Name: idx_af86866fd11df8ca; Type: INDEX; Schema: public; Owner: app-stages
--

CREATE INDEX idx_af86866fd11df8ca ON public.offre USING btree (etat_offre_id);


--
-- TOC entry 3268 (class 1259 OID 16592)
-- Name: idx_b6f3164d4cc8505a; Type: INDEX; Schema: public; Owner: app-stages
--

CREATE INDEX idx_b6f3164d4cc8505a ON public.offre_consultee USING btree (offre_id);


--
-- TOC entry 3269 (class 1259 OID 16591)
-- Name: idx_b6f3164df1fb3bf7; Type: INDEX; Schema: public; Owner: app-stages
--

CREATE INDEX idx_b6f3164df1fb3bf7 ON public.offre_consultee USING btree (compte_etudiant_id);


--
-- TOC entry 3265 (class 1259 OID 16584)
-- Name: idx_e33bd3b84cc8505a; Type: INDEX; Schema: public; Owner: app-stages
--

CREATE INDEX idx_e33bd3b84cc8505a ON public.candidature USING btree (offre_id);


--
-- TOC entry 3266 (class 1259 OID 16583)
-- Name: idx_e33bd3b8f1fb3bf7; Type: INDEX; Schema: public; Owner: app-stages
--

CREATE INDEX idx_e33bd3b8f1fb3bf7 ON public.candidature USING btree (compte_etudiant_id);


--
-- TOC entry 3267 (class 1259 OID 16585)
-- Name: idx_e33bd3b8f62b59f; Type: INDEX; Schema: public; Owner: app-stages
--

CREATE INDEX idx_e33bd3b8f62b59f ON public.candidature USING btree (etat_candidature_id);


--
-- TOC entry 3244 (class 1259 OID 16445)
-- Name: idx_f3ceb11e6b079d8; Type: INDEX; Schema: public; Owner: app-stages
--

CREATE INDEX idx_f3ceb11e6b079d8 ON public.compte_etudiant USING btree (etat_recherche_id);


--
-- TOC entry 3245 (class 1259 OID 16444)
-- Name: uniq_f3ceb11eaa08cb10; Type: INDEX; Schema: public; Owner: app-stages
--

CREATE UNIQUE INDEX uniq_f3ceb11eaa08cb10 ON public.compte_etudiant USING btree (login);


--
-- TOC entry 3246 (class 1259 OID 16635)
-- Name: uniq_f3ceb11eddeab1a3; Type: INDEX; Schema: public; Owner: app-stages
--

CREATE UNIQUE INDEX uniq_f3ceb11eddeab1a3 ON public.compte_etudiant USING btree (etudiant_id);


--
-- TOC entry 3287 (class 2620 OID 16420)
-- Name: messenger_messages notify_trigger; Type: TRIGGER; Schema: public; Owner: app-stages
--

CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON public.messenger_messages FOR EACH ROW EXECUTE FUNCTION public.notify_messenger_messages();


--
-- TOC entry 3285 (class 2606 OID 16630)
-- Name: offre_retenue fk_3f0a4cc54cc8505a; Type: FK CONSTRAINT; Schema: public; Owner: app-stages
--

ALTER TABLE ONLY public.offre_retenue
    ADD CONSTRAINT fk_3f0a4cc54cc8505a FOREIGN KEY (offre_id) REFERENCES public.offre(id);


--
-- TOC entry 3286 (class 2606 OID 16625)
-- Name: offre_retenue fk_3f0a4cc5f1fb3bf7; Type: FK CONSTRAINT; Schema: public; Owner: app-stages
--

ALTER TABLE ONLY public.offre_retenue
    ADD CONSTRAINT fk_3f0a4cc5f1fb3bf7 FOREIGN KEY (compte_etudiant_id) REFERENCES public.compte_etudiant(id);


--
-- TOC entry 3278 (class 2606 OID 16533)
-- Name: offre fk_af86866fa4aeafea; Type: FK CONSTRAINT; Schema: public; Owner: app-stages
--

ALTER TABLE ONLY public.offre
    ADD CONSTRAINT fk_af86866fa4aeafea FOREIGN KEY (entreprise_id) REFERENCES public.entreprise(id);


--
-- TOC entry 3279 (class 2606 OID 16528)
-- Name: offre fk_af86866fd11df8ca; Type: FK CONSTRAINT; Schema: public; Owner: app-stages
--

ALTER TABLE ONLY public.offre
    ADD CONSTRAINT fk_af86866fd11df8ca FOREIGN KEY (etat_offre_id) REFERENCES public.etat_offre(id);


--
-- TOC entry 3283 (class 2606 OID 16620)
-- Name: offre_consultee fk_b6f3164d4cc8505a; Type: FK CONSTRAINT; Schema: public; Owner: app-stages
--

ALTER TABLE ONLY public.offre_consultee
    ADD CONSTRAINT fk_b6f3164d4cc8505a FOREIGN KEY (offre_id) REFERENCES public.offre(id);


--
-- TOC entry 3284 (class 2606 OID 16615)
-- Name: offre_consultee fk_b6f3164df1fb3bf7; Type: FK CONSTRAINT; Schema: public; Owner: app-stages
--

ALTER TABLE ONLY public.offre_consultee
    ADD CONSTRAINT fk_b6f3164df1fb3bf7 FOREIGN KEY (compte_etudiant_id) REFERENCES public.compte_etudiant(id);


--
-- TOC entry 3280 (class 2606 OID 16605)
-- Name: candidature fk_e33bd3b84cc8505a; Type: FK CONSTRAINT; Schema: public; Owner: app-stages
--

ALTER TABLE ONLY public.candidature
    ADD CONSTRAINT fk_e33bd3b84cc8505a FOREIGN KEY (offre_id) REFERENCES public.offre(id);


--
-- TOC entry 3281 (class 2606 OID 16600)
-- Name: candidature fk_e33bd3b8f1fb3bf7; Type: FK CONSTRAINT; Schema: public; Owner: app-stages
--

ALTER TABLE ONLY public.candidature
    ADD CONSTRAINT fk_e33bd3b8f1fb3bf7 FOREIGN KEY (compte_etudiant_id) REFERENCES public.compte_etudiant(id);


--
-- TOC entry 3282 (class 2606 OID 16610)
-- Name: candidature fk_e33bd3b8f62b59f; Type: FK CONSTRAINT; Schema: public; Owner: app-stages
--

ALTER TABLE ONLY public.candidature
    ADD CONSTRAINT fk_e33bd3b8f62b59f FOREIGN KEY (etat_candidature_id) REFERENCES public.etat_candidature(id);


--
-- TOC entry 3276 (class 2606 OID 16523)
-- Name: compte_etudiant fk_f3ceb11e6b079d8; Type: FK CONSTRAINT; Schema: public; Owner: app-stages
--

ALTER TABLE ONLY public.compte_etudiant
    ADD CONSTRAINT fk_f3ceb11e6b079d8 FOREIGN KEY (etat_recherche_id) REFERENCES public.etat_recherche(id);


--
-- TOC entry 3277 (class 2606 OID 16558)
-- Name: compte_etudiant fk_f3ceb11eddeab1a3; Type: FK CONSTRAINT; Schema: public; Owner: app-stages
--

ALTER TABLE ONLY public.compte_etudiant
    ADD CONSTRAINT fk_f3ceb11eddeab1a3 FOREIGN KEY (etudiant_id) REFERENCES public.etudiant(id);


-- Completed on 2023-01-25 12:19:31

--
-- PostgreSQL database dump complete
--


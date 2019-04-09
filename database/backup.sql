--
-- PostgreSQL database dump
--

-- Dumped from database version 10.5
-- Dumped by pg_dump version 10.5

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


--
-- Name: kerjasama_instansi_insert(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.kerjasama_instansi_insert() RETURNS trigger
    LANGUAGE plpgsql
    AS $$declare hitung int;
begin
select count(kerjasama_instansi.no_plat) into hitung from kerjasama_instansi where
kerjasama_instansi.no_plat = new.no_plat and
(
	(
		kerjasama_instansi.waktu_mulai >= new.waktu_mulai 
		and kerjasama_instansi.waktu_mulai < new.waktu_selesai
	) or (
		kerjasama_instansi.waktu_selesai > new.waktu_mulai 
		and kerjasama_instansi.waktu_selesai <= new.waktu_selesai
	) or (
		new.waktu_mulai >= kerjasama_instansi.waktu_mulai 
		and new.waktu_mulai < kerjasama_instansi.waktu_selesai
	) or (
		new.waktu_selesai > kerjasama_instansi.waktu_mulai 
		and new.waktu_selesai <= kerjasama_instansi.waktu_selesai
	)
);

if(hitung!=0 or new.waktu_mulai >= new.waktu_selesai or new.waktu_mulai <= now())then
new.no_plat = null;
end if;

return new;

end
$$;


ALTER FUNCTION public.kerjasama_instansi_insert() OWNER TO postgres;

--
-- Name: registrasi_insert(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.registrasi_insert() RETURNS trigger
    LANGUAGE plpgsql
    AS $$begin
select max(no_datang) into new.no_datang from registrasi where nik = new.nik;
if new.no_datang is null then
new.no_datang = 1;
else
new.no_datang = new.no_datang+1;
end if;
return new;
end;
$$;


ALTER FUNCTION public.registrasi_insert() OWNER TO postgres;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: donor; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.donor (
    nik character varying(16) NOT NULL,
    no_datang integer NOT NULL,
    aftap_id integer,
    nomor_kantung integer NOT NULL,
    reaksi_donor character varying(255),
    jumlah_ambil numeric
);


ALTER TABLE public.donor OWNER TO postgres;

--
-- Name: donor_nomor_kantung_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.donor_nomor_kantung_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.donor_nomor_kantung_seq OWNER TO postgres;

--
-- Name: donor_nomor_kantung_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.donor_nomor_kantung_seq OWNED BY public.donor.nomor_kantung;


--
-- Name: instansi; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.instansi (
    instansi_id integer NOT NULL,
    nama character varying(255),
    latitude numeric(10,6),
    longitude numeric(10,6)
);


ALTER TABLE public.instansi OWNER TO postgres;

--
-- Name: instansi_instansi_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.instansi_instansi_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.instansi_instansi_id_seq OWNER TO postgres;

--
-- Name: instansi_instansi_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.instansi_instansi_id_seq OWNED BY public.instansi.instansi_id;


--
-- Name: jenis_donor; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.jenis_donor (
    jenis_id integer NOT NULL,
    nama character varying(255)
);


ALTER TABLE public.jenis_donor OWNER TO postgres;

--
-- Name: jenis_donor_jenis_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.jenis_donor_jenis_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.jenis_donor_jenis_id_seq OWNER TO postgres;

--
-- Name: jenis_donor_jenis_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.jenis_donor_jenis_id_seq OWNED BY public.jenis_donor.jenis_id;


--
-- Name: jenis_kantong; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.jenis_kantong (
    jkantong_id integer NOT NULL,
    keterangan character varying(255)
);


ALTER TABLE public.jenis_kantong OWNER TO postgres;

--
-- Name: jenis_kantong_jkantong_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.jenis_kantong_jkantong_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.jenis_kantong_jkantong_id_seq OWNER TO postgres;

--
-- Name: jenis_kantong_jkantong_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.jenis_kantong_jkantong_id_seq OWNED BY public.jenis_kantong.jkantong_id;


--
-- Name: kendaraan; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.kendaraan (
    no_plat character varying(10) NOT NULL,
    nama character varying(255),
    keterangan character varying(255)
);


ALTER TABLE public.kendaraan OWNER TO postgres;

--
-- Name: kerjasama_instansi; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.kerjasama_instansi (
    no_plat character varying(10) NOT NULL,
    waktu_mulai timestamp without time zone NOT NULL,
    waktu_selesai timestamp without time zone NOT NULL,
    instansi_id integer,
    target integer,
    lat numeric(10,6),
    long numeric(10,6)
);


ALTER TABLE public.kerjasama_instansi OWNER TO postgres;

--
-- Name: kondisi; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.kondisi (
    kondisi_id integer NOT NULL,
    kondisi character varying(255)
);


ALTER TABLE public.kondisi OWNER TO postgres;

--
-- Name: kondisi_kondisi_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.kondisi_kondisi_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.kondisi_kondisi_id_seq OWNER TO postgres;

--
-- Name: kondisi_kondisi_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.kondisi_kondisi_id_seq OWNED BY public.kondisi.kondisi_id;


--
-- Name: kondisi_registrasi; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.kondisi_registrasi (
    nik character varying(16) NOT NULL,
    no_datang integer NOT NULL,
    kondisi_id integer NOT NULL,
    pilihan_id integer
);


ALTER TABLE public.kondisi_registrasi OWNER TO postgres;

--
-- Name: member; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.member (
    nik character varying(16) NOT NULL,
    nama character varying(255),
    jenis_kelamin character varying(255),
    alamat character varying(255),
    pekerjaan character varying(255),
    tempat_lahir character varying(255),
    tanggal_lahir date
);


ALTER TABLE public.member OWNER TO postgres;

--
-- Name: pemeriksaan_hb; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pemeriksaan_hb (
    nik character varying(16) NOT NULL,
    no_datang integer NOT NULL,
    hb_id integer,
    hb integer,
    hct integer,
    berat_badan integer,
    gol_darah character varying(2),
    rh character varying(1)
);


ALTER TABLE public.pemeriksaan_hb OWNER TO postgres;

--
-- Name: pemeriksaan_paramedik; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pemeriksaan_paramedik (
    nik character varying(16) NOT NULL,
    no_datang integer NOT NULL,
    paramedik_id integer,
    tensi integer,
    suhu integer,
    nadi integer,
    riwayat_medis character varying(255),
    jkantong_id integer,
    jumlah_pengambilan integer
);


ALTER TABLE public.pemeriksaan_paramedik OWNER TO postgres;

--
-- Name: petugas_aftap; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.petugas_aftap (
    aftap_id integer NOT NULL
);


ALTER TABLE public.petugas_aftap OWNER TO postgres;

--
-- Name: petugas_hb; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.petugas_hb (
    hb_id integer NOT NULL
);


ALTER TABLE public.petugas_hb OWNER TO postgres;

--
-- Name: petugas_paramedik; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.petugas_paramedik (
    paramedik_id integer NOT NULL
);


ALTER TABLE public.petugas_paramedik OWNER TO postgres;

--
-- Name: pilihan_kondisi; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pilihan_kondisi (
    pilihan_id integer NOT NULL,
    keterangan character varying(255)
);


ALTER TABLE public.pilihan_kondisi OWNER TO postgres;

--
-- Name: pilihan_kondisi_pilihan_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pilihan_kondisi_pilihan_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.pilihan_kondisi_pilihan_id_seq OWNER TO postgres;

--
-- Name: pilihan_kondisi_pilihan_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.pilihan_kondisi_pilihan_id_seq OWNED BY public.pilihan_kondisi.pilihan_id;


--
-- Name: registrasi; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.registrasi (
    nik character varying(16) NOT NULL,
    no_datang integer NOT NULL,
    jenis_id integer,
    status_id integer,
    tanggal timestamp without time zone DEFAULT now()
);


ALTER TABLE public.registrasi OWNER TO postgres;

--
-- Name: registrasi_event; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.registrasi_event (
    nik character varying(16) NOT NULL,
    no_datang integer NOT NULL,
    no_plat character varying(10),
    waktu_mulai timestamp without time zone,
    waktu_selesai timestamp without time zone
);


ALTER TABLE public.registrasi_event OWNER TO postgres;

--
-- Name: status_registrasi; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.status_registrasi (
    status_id integer NOT NULL,
    keterangan character varying(255)
);


ALTER TABLE public.status_registrasi OWNER TO postgres;

--
-- Name: status_registrasi_status_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.status_registrasi_status_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.status_registrasi_status_id_seq OWNER TO postgres;

--
-- Name: status_registrasi_status_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.status_registrasi_status_id_seq OWNED BY public.status_registrasi.status_id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    user_id integer NOT NULL,
    nama character varying(255),
    jenis_kelamin character varying(10),
    no_handphone character varying(13),
    username character varying(255),
    password character varying(255)
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_user_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_user_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_user_id_seq OWNER TO postgres;

--
-- Name: users_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_user_id_seq OWNED BY public.users.user_id;


--
-- Name: donor nomor_kantung; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.donor ALTER COLUMN nomor_kantung SET DEFAULT nextval('public.donor_nomor_kantung_seq'::regclass);


--
-- Name: instansi instansi_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.instansi ALTER COLUMN instansi_id SET DEFAULT nextval('public.instansi_instansi_id_seq'::regclass);


--
-- Name: jenis_donor jenis_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jenis_donor ALTER COLUMN jenis_id SET DEFAULT nextval('public.jenis_donor_jenis_id_seq'::regclass);


--
-- Name: jenis_kantong jkantong_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jenis_kantong ALTER COLUMN jkantong_id SET DEFAULT nextval('public.jenis_kantong_jkantong_id_seq'::regclass);


--
-- Name: kondisi kondisi_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kondisi ALTER COLUMN kondisi_id SET DEFAULT nextval('public.kondisi_kondisi_id_seq'::regclass);


--
-- Name: pilihan_kondisi pilihan_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pilihan_kondisi ALTER COLUMN pilihan_id SET DEFAULT nextval('public.pilihan_kondisi_pilihan_id_seq'::regclass);


--
-- Name: status_registrasi status_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.status_registrasi ALTER COLUMN status_id SET DEFAULT nextval('public.status_registrasi_status_id_seq'::regclass);


--
-- Name: users user_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN user_id SET DEFAULT nextval('public.users_user_id_seq'::regclass);


--
-- Data for Name: donor; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.donor (nik, no_datang, aftap_id, nomor_kantung, reaksi_donor, jumlah_ambil) FROM stdin;
\.


--
-- Data for Name: instansi; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.instansi (instansi_id, nama, latitude, longitude) FROM stdin;
2	Universitas Andalas	-0.914564	100.459541
3	Balai Kota Padang	-0.876374	100.387421
\.


--
-- Data for Name: jenis_donor; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.jenis_donor (jenis_id, nama) FROM stdin;
\.


--
-- Data for Name: jenis_kantong; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.jenis_kantong (jkantong_id, keterangan) FROM stdin;
\.


--
-- Data for Name: kendaraan; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.kendaraan (no_plat, nama, keterangan) FROM stdin;
BA1234AB	Avanza	Putih
BA4321AB	Innova	Hitam
\.


--
-- Data for Name: kerjasama_instansi; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.kerjasama_instansi (no_plat, waktu_mulai, waktu_selesai, instansi_id, target, lat, long) FROM stdin;
BA1234AB	2019-04-11 10:00:00	2019-04-11 12:00:00	2	150	-0.916966	100.455227
BA1234AB	2019-04-11 13:00:00	2019-04-11 15:00:00	3	150	-0.924247	100.362589
BA1234AB	2019-04-11 12:00:00	2019-04-11 13:00:00	3	150	0.000000	0.000000
\.


--
-- Data for Name: kondisi; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.kondisi (kondisi_id, kondisi) FROM stdin;
\.


--
-- Data for Name: kondisi_registrasi; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.kondisi_registrasi (nik, no_datang, kondisi_id, pilihan_id) FROM stdin;
\.


--
-- Data for Name: member; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.member (nik, nama, jenis_kelamin, alamat, pekerjaan, tempat_lahir, tanggal_lahir) FROM stdin;
\.


--
-- Data for Name: pemeriksaan_hb; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.pemeriksaan_hb (nik, no_datang, hb_id, hb, hct, berat_badan, gol_darah, rh) FROM stdin;
\.


--
-- Data for Name: pemeriksaan_paramedik; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.pemeriksaan_paramedik (nik, no_datang, paramedik_id, tensi, suhu, nadi, riwayat_medis, jkantong_id, jumlah_pengambilan) FROM stdin;
\.


--
-- Data for Name: petugas_aftap; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.petugas_aftap (aftap_id) FROM stdin;
\.


--
-- Data for Name: petugas_hb; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.petugas_hb (hb_id) FROM stdin;
\.


--
-- Data for Name: petugas_paramedik; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.petugas_paramedik (paramedik_id) FROM stdin;
\.


--
-- Data for Name: pilihan_kondisi; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.pilihan_kondisi (pilihan_id, keterangan) FROM stdin;
\.


--
-- Data for Name: registrasi; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.registrasi (nik, no_datang, jenis_id, status_id, tanggal) FROM stdin;
\.


--
-- Data for Name: registrasi_event; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.registrasi_event (nik, no_datang, no_plat, waktu_mulai, waktu_selesai) FROM stdin;
\.


--
-- Data for Name: status_registrasi; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.status_registrasi (status_id, keterangan) FROM stdin;
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (user_id, nama, jenis_kelamin, no_handphone, username, password) FROM stdin;
\.


--
-- Name: donor_nomor_kantung_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.donor_nomor_kantung_seq', 1, false);


--
-- Name: instansi_instansi_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.instansi_instansi_id_seq', 3, true);


--
-- Name: jenis_donor_jenis_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.jenis_donor_jenis_id_seq', 9, true);


--
-- Name: jenis_kantong_jkantong_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.jenis_kantong_jkantong_id_seq', 1, false);


--
-- Name: kondisi_kondisi_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.kondisi_kondisi_id_seq', 2, true);


--
-- Name: pilihan_kondisi_pilihan_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.pilihan_kondisi_pilihan_id_seq', 1, false);


--
-- Name: status_registrasi_status_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.status_registrasi_status_id_seq', 1, false);


--
-- Name: users_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_user_id_seq', 1, true);


--
-- Name: donor donor_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.donor
    ADD CONSTRAINT donor_pkey PRIMARY KEY (nik, no_datang);


--
-- Name: instansi instansi_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.instansi
    ADD CONSTRAINT instansi_pkey PRIMARY KEY (instansi_id);


--
-- Name: jenis_donor jenis_donor_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jenis_donor
    ADD CONSTRAINT jenis_donor_pkey PRIMARY KEY (jenis_id);


--
-- Name: jenis_kantong jenis_kantong_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jenis_kantong
    ADD CONSTRAINT jenis_kantong_pkey PRIMARY KEY (jkantong_id);


--
-- Name: kendaraan kendaraan_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kendaraan
    ADD CONSTRAINT kendaraan_pkey PRIMARY KEY (no_plat);


--
-- Name: kerjasama_instansi kerjasama_instansi_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kerjasama_instansi
    ADD CONSTRAINT kerjasama_instansi_pkey PRIMARY KEY (no_plat, waktu_mulai, waktu_selesai);


--
-- Name: kondisi kondisi_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kondisi
    ADD CONSTRAINT kondisi_pkey PRIMARY KEY (kondisi_id);


--
-- Name: kondisi_registrasi kondisi_registrasi_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kondisi_registrasi
    ADD CONSTRAINT kondisi_registrasi_pkey PRIMARY KEY (nik, no_datang, kondisi_id);


--
-- Name: member member_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.member
    ADD CONSTRAINT member_pkey PRIMARY KEY (nik);


--
-- Name: pemeriksaan_hb pemeriksaan_hb_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pemeriksaan_hb
    ADD CONSTRAINT pemeriksaan_hb_pkey PRIMARY KEY (nik, no_datang);


--
-- Name: pemeriksaan_paramedik pemeriksaan_paramedik_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pemeriksaan_paramedik
    ADD CONSTRAINT pemeriksaan_paramedik_pkey PRIMARY KEY (nik, no_datang);


--
-- Name: petugas_aftap petugas_aftap_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.petugas_aftap
    ADD CONSTRAINT petugas_aftap_pkey PRIMARY KEY (aftap_id);


--
-- Name: petugas_hb petugas_hb_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.petugas_hb
    ADD CONSTRAINT petugas_hb_pkey PRIMARY KEY (hb_id);


--
-- Name: petugas_paramedik petugas_paramedik_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.petugas_paramedik
    ADD CONSTRAINT petugas_paramedik_pkey PRIMARY KEY (paramedik_id);


--
-- Name: pilihan_kondisi pilihan_kondisi_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pilihan_kondisi
    ADD CONSTRAINT pilihan_kondisi_pkey PRIMARY KEY (pilihan_id);


--
-- Name: registrasi_event registrasi_event_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.registrasi_event
    ADD CONSTRAINT registrasi_event_pkey PRIMARY KEY (nik, no_datang);


--
-- Name: registrasi registrasi_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.registrasi
    ADD CONSTRAINT registrasi_pkey PRIMARY KEY (nik, no_datang);


--
-- Name: status_registrasi status_registrasi_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.status_registrasi
    ADD CONSTRAINT status_registrasi_pkey PRIMARY KEY (status_id);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (user_id);


--
-- Name: kerjasama_instansi kerjasama_instansi_onInsert; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER "kerjasama_instansi_onInsert" BEFORE INSERT ON public.kerjasama_instansi FOR EACH ROW EXECUTE PROCEDURE public.kerjasama_instansi_insert();


--
-- Name: registrasi oninsert_registrasi; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER oninsert_registrasi BEFORE INSERT ON public.registrasi FOR EACH ROW EXECUTE PROCEDURE public.registrasi_insert();


--
-- Name: donor donor_aftap_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.donor
    ADD CONSTRAINT donor_aftap_id_fkey FOREIGN KEY (aftap_id) REFERENCES public.petugas_aftap(aftap_id);


--
-- Name: donor donor_nik_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.donor
    ADD CONSTRAINT donor_nik_fkey FOREIGN KEY (nik, no_datang) REFERENCES public.pemeriksaan_paramedik(nik, no_datang);


--
-- Name: kerjasama_instansi kerjasama_instansi_instansi_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kerjasama_instansi
    ADD CONSTRAINT kerjasama_instansi_instansi_id_fkey FOREIGN KEY (instansi_id) REFERENCES public.instansi(instansi_id);


--
-- Name: kerjasama_instansi kerjasama_instansi_no_plat_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kerjasama_instansi
    ADD CONSTRAINT kerjasama_instansi_no_plat_fkey FOREIGN KEY (no_plat) REFERENCES public.kendaraan(no_plat);


--
-- Name: kondisi_registrasi kondisi_registrasi_kondisi_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kondisi_registrasi
    ADD CONSTRAINT kondisi_registrasi_kondisi_id_fkey FOREIGN KEY (kondisi_id) REFERENCES public.kondisi(kondisi_id) ON DELETE CASCADE;


--
-- Name: kondisi_registrasi kondisi_registrasi_nik_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kondisi_registrasi
    ADD CONSTRAINT kondisi_registrasi_nik_fkey FOREIGN KEY (nik, no_datang) REFERENCES public.registrasi(nik, no_datang) ON DELETE CASCADE;


--
-- Name: kondisi_registrasi kondisi_registrasi_pilihan_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kondisi_registrasi
    ADD CONSTRAINT kondisi_registrasi_pilihan_id_fkey FOREIGN KEY (pilihan_id) REFERENCES public.pilihan_kondisi(pilihan_id) ON DELETE CASCADE;


--
-- Name: pemeriksaan_hb pemeriksaan_hb_hb_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pemeriksaan_hb
    ADD CONSTRAINT pemeriksaan_hb_hb_id_fkey FOREIGN KEY (hb_id) REFERENCES public.petugas_hb(hb_id) ON DELETE CASCADE;


--
-- Name: pemeriksaan_hb pemeriksaan_hb_nik_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pemeriksaan_hb
    ADD CONSTRAINT pemeriksaan_hb_nik_fkey FOREIGN KEY (nik, no_datang) REFERENCES public.registrasi(nik, no_datang) ON DELETE CASCADE;


--
-- Name: pemeriksaan_paramedik pemeriksaan_paramedik_jkantong_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pemeriksaan_paramedik
    ADD CONSTRAINT pemeriksaan_paramedik_jkantong_id_fkey FOREIGN KEY (jkantong_id) REFERENCES public.jenis_kantong(jkantong_id) ON DELETE CASCADE;


--
-- Name: pemeriksaan_paramedik pemeriksaan_paramedik_nik_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pemeriksaan_paramedik
    ADD CONSTRAINT pemeriksaan_paramedik_nik_fkey FOREIGN KEY (nik, no_datang) REFERENCES public.pemeriksaan_hb(nik, no_datang) ON DELETE CASCADE;


--
-- Name: pemeriksaan_paramedik pemeriksaan_paramedik_paramedik_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pemeriksaan_paramedik
    ADD CONSTRAINT pemeriksaan_paramedik_paramedik_id_fkey FOREIGN KEY (paramedik_id) REFERENCES public.petugas_paramedik(paramedik_id) ON DELETE CASCADE;


--
-- Name: petugas_aftap petugas_aftap_aftap_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.petugas_aftap
    ADD CONSTRAINT petugas_aftap_aftap_id_fkey FOREIGN KEY (aftap_id) REFERENCES public.users(user_id);


--
-- Name: petugas_hb petugas_hb_hb_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.petugas_hb
    ADD CONSTRAINT petugas_hb_hb_id_fkey FOREIGN KEY (hb_id) REFERENCES public.users(user_id);


--
-- Name: petugas_paramedik petugas_paramedik_paramedik_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.petugas_paramedik
    ADD CONSTRAINT petugas_paramedik_paramedik_id_fkey FOREIGN KEY (paramedik_id) REFERENCES public.users(user_id);


--
-- Name: registrasi_event registrasi_event_nik_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.registrasi_event
    ADD CONSTRAINT registrasi_event_nik_fkey FOREIGN KEY (nik, no_datang) REFERENCES public.registrasi(nik, no_datang);


--
-- Name: registrasi_event registrasi_event_no_plat_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.registrasi_event
    ADD CONSTRAINT registrasi_event_no_plat_fkey FOREIGN KEY (no_plat, waktu_mulai, waktu_selesai) REFERENCES public.kerjasama_instansi(no_plat, waktu_mulai, waktu_selesai);


--
-- Name: registrasi registrasi_jenis_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.registrasi
    ADD CONSTRAINT registrasi_jenis_id_fkey FOREIGN KEY (jenis_id) REFERENCES public.jenis_donor(jenis_id) ON DELETE CASCADE;


--
-- Name: registrasi registrasi_nik_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.registrasi
    ADD CONSTRAINT registrasi_nik_fkey FOREIGN KEY (nik) REFERENCES public.member(nik) ON DELETE CASCADE;


--
-- Name: registrasi registrasi_status_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.registrasi
    ADD CONSTRAINT registrasi_status_id_fkey FOREIGN KEY (status_id) REFERENCES public.status_registrasi(status_id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--


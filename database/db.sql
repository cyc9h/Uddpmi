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
-- Name: check_insert_donor(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.check_insert_donor() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
declare sts int;
begin
select status_id into sts from registrasi where registrasi.nik = new.nik and registrasi.no_datang = new.no_datang;
if sts != 3 then
	new.no_datang = null;
end if;
return new;
end;

$$;


ALTER FUNCTION public.check_insert_donor() OWNER TO postgres;

--
-- Name: check_insert_pemeriksaan_hb(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.check_insert_pemeriksaan_hb() RETURNS trigger
    LANGUAGE plpgsql
    AS $$declare sts int;
begin
select status_id into sts from registrasi where registrasi.nik = new.nik and registrasi.no_datang = new.no_datang;
if sts != 1 then
	new.no_datang = null;
end if;
return new;
end;
$$;


ALTER FUNCTION public.check_insert_pemeriksaan_hb() OWNER TO postgres;

--
-- Name: check_insert_pemeriksaan_paramedik(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.check_insert_pemeriksaan_paramedik() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
declare sts int;
begin
select status_id into sts from registrasi where registrasi.nik = new.nik and registrasi.no_datang = new.no_datang;
if sts != 2 then
	new.no_datang = null;
end if;
return new;
end;

$$;


ALTER FUNCTION public.check_insert_pemeriksaan_paramedik() OWNER TO postgres;

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

if new.no_datang = 1 and new.jenis_id = 2 then
new.jenis_id = 1;
end if;

return new;
end;
$$;


ALTER FUNCTION public.registrasi_insert() OWNER TO postgres;

--
-- Name: update_status_to_2(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.update_status_to_2() RETURNS trigger
    LANGUAGE plpgsql
    AS $$begin
update registrasi set status_id = 2 where no_datang=new.no_datang and nik=new.nik;
return null;
end;
$$;


ALTER FUNCTION public.update_status_to_2() OWNER TO postgres;

--
-- Name: update_status_to_3(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.update_status_to_3() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
begin
update registrasi set status_id = 3 where no_datang=new.no_datang and nik=new.nik;
return null;
end;

$$;


ALTER FUNCTION public.update_status_to_3() OWNER TO postgres;

--
-- Name: update_status_to_4(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.update_status_to_4() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
begin
update registrasi set status_id = 4 where no_datang=new.no_datang and nik=new.nik;
return null;
end;

$$;


ALTER FUNCTION public.update_status_to_4() OWNER TO postgres;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: donor; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.donor (
    nik character varying(16) NOT NULL,
    no_datang integer NOT NULL,
    aftap_id integer NOT NULL,
    nomor_kantong integer NOT NULL,
    reaksi_donor character varying(255) NOT NULL,
    jumlah_ambil numeric NOT NULL
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

ALTER SEQUENCE public.donor_nomor_kantung_seq OWNED BY public.donor.nomor_kantong;


--
-- Name: instansi; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.instansi (
    instansi_id integer NOT NULL,
    nama character varying(255) NOT NULL,
    latitude numeric(10,6) NOT NULL,
    longitude numeric(10,6) NOT NULL
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
    nama character varying(255) NOT NULL
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
    keterangan character varying(255) NOT NULL
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
    nama character varying(255) NOT NULL,
    keterangan character varying(255) NOT NULL
);


ALTER TABLE public.kendaraan OWNER TO postgres;

--
-- Name: kerjasama_instansi; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.kerjasama_instansi (
    no_plat character varying(10) NOT NULL,
    waktu_mulai timestamp without time zone NOT NULL,
    waktu_selesai timestamp without time zone NOT NULL,
    instansi_id integer NOT NULL,
    target integer NOT NULL,
    latitude numeric(10,6) NOT NULL,
    longitude numeric(10,6) NOT NULL
);


ALTER TABLE public.kerjasama_instansi OWNER TO postgres;

--
-- Name: kondisi; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.kondisi (
    kondisi_id integer NOT NULL,
    kondisi character varying(255) NOT NULL
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
    pilihan_id integer NOT NULL
);


ALTER TABLE public.kondisi_registrasi OWNER TO postgres;

--
-- Name: member; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.member (
    nik character varying(16) NOT NULL,
    nama character varying(255) NOT NULL,
    jenis_kelamin character varying(255) NOT NULL,
    alamat character varying(255) NOT NULL,
    pekerjaan character varying(255) NOT NULL,
    tempat_lahir character varying(255) NOT NULL,
    tanggal_lahir date NOT NULL
);


ALTER TABLE public.member OWNER TO postgres;

--
-- Name: pemeriksaan_hb; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pemeriksaan_hb (
    nik character varying(16) NOT NULL,
    no_datang integer NOT NULL,
    hb_id integer NOT NULL,
    hb integer NOT NULL,
    hct integer NOT NULL,
    berat_badan integer NOT NULL,
    gol_darah character varying(2) NOT NULL,
    rh character varying(1) NOT NULL
);


ALTER TABLE public.pemeriksaan_hb OWNER TO postgres;

--
-- Name: pemeriksaan_paramedik; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pemeriksaan_paramedik (
    nik character varying(16) NOT NULL,
    no_datang integer NOT NULL,
    paramedik_id integer NOT NULL,
    tensi integer NOT NULL,
    suhu integer NOT NULL,
    nadi integer NOT NULL,
    riwayat_medis character varying(255) NOT NULL,
    jkantong_id integer NOT NULL,
    jumlah_pengambilan integer NOT NULL
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
    keterangan character varying(255) NOT NULL
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
    jenis_id integer NOT NULL,
    status_id integer NOT NULL,
    tanggal timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.registrasi OWNER TO postgres;

--
-- Name: registrasi_event; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.registrasi_event (
    nik character varying(16) NOT NULL,
    no_datang integer NOT NULL,
    no_plat character varying(10) NOT NULL,
    waktu_mulai timestamp without time zone NOT NULL,
    waktu_selesai timestamp without time zone NOT NULL
);


ALTER TABLE public.registrasi_event OWNER TO postgres;

--
-- Name: status_registrasi; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.status_registrasi (
    status_id integer NOT NULL,
    keterangan character varying(255) NOT NULL
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
    nama character varying(255) NOT NULL,
    jenis_kelamin character varying(10) NOT NULL,
    no_handphone character varying(13) NOT NULL,
    username character varying(255) NOT NULL,
    password character varying(255) NOT NULL
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
-- Name: donor nomor_kantong; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.donor ALTER COLUMN nomor_kantong SET DEFAULT nextval('public.donor_nomor_kantung_seq'::regclass);


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

COPY public.donor (nik, no_datang, aftap_id, nomor_kantong, reaksi_donor, jumlah_ambil) FROM stdin;
1	1	18	1	1	1
2	2	18	1	1	1
\.


--
-- Data for Name: instansi; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.instansi (instansi_id, nama, latitude, longitude) FROM stdin;
3	Balai Kota Padang	-0.876374	100.387421
6	STKIP PGRI Sumatera Barat	-0.909681	100.367650
7	Universitas Bung Hatta	-0.908402	100.365499
\.


--
-- Data for Name: jenis_donor; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.jenis_donor (jenis_id, nama) FROM stdin;
2	Ulang
1	Baru
3	Pengganti
4	Bayaran
\.


--
-- Data for Name: jenis_kantong; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.jenis_kantong (jkantong_id, keterangan) FROM stdin;
2	Single
3	Double
4	Triple
5	Quadruple
6	Pediatrik
\.


--
-- Data for Name: kendaraan; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.kendaraan (no_plat, nama, keterangan) FROM stdin;
BA1234AB	Avanza	Hitam
BA4321AB	Innova	Putih
\.


--
-- Data for Name: kerjasama_instansi; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.kerjasama_instansi (no_plat, waktu_mulai, waktu_selesai, instansi_id, target, latitude, longitude) FROM stdin;
BA1234AB	2019-04-15 09:00:00	2019-04-15 11:00:00	3	150	-0.876374	100.387421
BA4321AB	2019-04-15 09:00:00	2019-04-15 12:00:00	6	150	-0.909681	100.367650
BA1234AB	2019-04-15 11:00:00	2019-04-15 12:00:00	7	100	-0.908402	100.365499
\.


--
-- Data for Name: kondisi; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.kondisi (kondisi_id, kondisi) FROM stdin;
1	Sehat saat ini
2	Tiga bulan terakhir mendapatkan pengobatan/ sakit/ operasi
3	Pernah ada riwayat/ keluhan penyakit ginjal/ jantung/ kencing manis/ TBC, ashma, alergi
4	Pernah ada riwayat/ keluhan penyakit radang akut/ maag akut/ kronis, gangguan darah/ hemofilia
5	Pernah ada riwayat/ keluhan penyakit kanker/ tumor, penyakit kronis lain
6	Sering pingsan/ kejang-kejang
7	Pernah kontak dengan penderita AIDS/ ODHA atau WPS
8	Apakah anda sedang atau pernah mendapat pengobatan sifilis atau GO (kencing manis)
9	Laki-laki : Apakah anda pernah berhubungan seksual dengan laki-laki, walaupun sekali
10	Ada kemungkinan gejala Hepatitis B/C, Shypilis, malaria
11	Mendapatkan hasil positif untuk tes HIV/AIDS
12	Pernah pergi ke daerah endemi malaria
13	Sedang minum obat yang mengandung aspirin atau antibiotik dalam 3 hari terakhir
14	Mendapatkan imunisasi 2-4 minggu terakhir
15	Mendapatkan transfusi darah dalam 12 bulan terakhir
16	Pernah digigit binatang yang menderita rabies 1 tahun terakhir
17	Pernah mendonorkan darah kurang dari 3 bulan terakhir
18	TIdur malam minimal 5-6 jam
19	Pernah mengonsumsi narkoba atau pecandu alkohol
20	Bagi wanita : tidak sedang haid, hamil/ menyusui
\.


--
-- Data for Name: kondisi_registrasi; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.kondisi_registrasi (nik, no_datang, kondisi_id, pilihan_id) FROM stdin;
1	1	10	3
1	1	8	3
1	1	20	3
1	1	9	3
1	1	11	3
1	1	14	3
1	1	15	3
1	1	3	3
1	1	5	3
1	1	4	3
1	1	16	3
1	1	7	3
1	1	17	3
1	1	19	3
1	1	12	3
1	1	13	3
1	1	1	3
1	1	6	3
1	1	18	3
1	1	2	3
2	1	10	3
2	1	8	3
2	1	20	3
2	1	9	3
2	1	11	3
2	1	14	3
2	1	15	3
2	1	3	3
2	1	5	3
2	1	4	3
2	1	16	3
2	1	7	3
2	1	17	3
2	1	19	3
2	1	12	3
2	1	13	3
2	1	1	3
2	1	6	3
2	1	18	3
2	1	2	3
3	1	10	3
3	1	8	3
3	1	20	3
3	1	9	3
3	1	11	3
3	1	14	3
3	1	15	3
3	1	3	3
3	1	5	3
3	1	4	3
3	1	16	3
3	1	7	3
3	1	17	3
3	1	19	3
3	1	12	3
3	1	13	3
3	1	1	3
3	1	6	3
3	1	18	3
3	1	2	3
4	1	10	3
4	1	8	3
4	1	20	3
4	1	9	3
4	1	11	3
4	1	14	3
4	1	15	3
4	1	3	3
4	1	5	3
4	1	4	3
4	1	16	3
4	1	7	3
4	1	17	3
4	1	19	3
4	1	12	3
4	1	13	3
4	1	1	3
4	1	6	3
4	1	18	3
4	1	2	3
2	2	10	3
2	2	8	3
2	2	20	3
2	2	9	3
2	2	11	3
2	2	14	3
2	2	15	3
2	2	3	3
2	2	5	3
2	2	4	3
2	2	16	3
2	2	7	3
2	2	17	3
2	2	19	3
2	2	12	3
2	2	13	3
2	2	1	3
2	2	6	3
2	2	18	3
2	2	2	3
3	2	10	3
3	2	8	3
3	2	20	3
3	2	9	3
3	2	11	3
3	2	14	3
3	2	15	3
3	2	3	3
3	2	5	3
3	2	4	3
3	2	16	3
3	2	7	3
3	2	17	3
3	2	19	3
3	2	12	3
3	2	13	3
3	2	1	3
3	2	6	3
3	2	18	3
3	2	2	3
4	2	10	3
4	2	8	3
4	2	20	3
4	2	9	3
4	2	11	3
4	2	14	3
4	2	15	3
4	2	3	3
4	2	5	3
4	2	4	3
4	2	16	3
4	2	7	3
4	2	17	3
4	2	19	3
4	2	12	3
4	2	13	3
4	2	1	3
4	2	6	3
4	2	18	3
4	2	2	3
1	2	10	3
1	2	8	3
1	2	20	3
1	2	9	3
1	2	11	3
1	2	14	3
1	2	15	3
1	2	3	3
1	2	5	3
1	2	4	3
1	2	16	3
1	2	7	3
1	2	17	3
1	2	19	3
1	2	12	3
1	2	13	3
1	2	1	3
1	2	6	3
1	2	18	3
1	2	2	3
\.


--
-- Data for Name: member; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.member (nik, nama, jenis_kelamin, alamat, pekerjaan, tempat_lahir, tanggal_lahir) FROM stdin;
1	1	Pria	1	1	1	2000-01-01
2	2	Wanita	2	2	2	1981-02-02
3	3	Wanita	3	3	3	1992-03-03
4	4	Wanita	4	4	4	2008-04-04
\.


--
-- Data for Name: pemeriksaan_hb; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.pemeriksaan_hb (nik, no_datang, hb_id, hb, hct, berat_badan, gol_darah, rh) FROM stdin;
1	1	17	1	1	1	A	+
1	2	17	1	1	1	A	+
4	2	17	1	1	1	A	-
2	2	17	1	1	1	B	-
\.


--
-- Data for Name: pemeriksaan_paramedik; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.pemeriksaan_paramedik (nik, no_datang, paramedik_id, tensi, suhu, nadi, riwayat_medis, jkantong_id, jumlah_pengambilan) FROM stdin;
1	1	19	1	1	1	1	2	1
2	2	19	1	1	1	1	2	1
\.


--
-- Data for Name: petugas_aftap; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.petugas_aftap (aftap_id) FROM stdin;
1
18
\.


--
-- Data for Name: petugas_hb; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.petugas_hb (hb_id) FROM stdin;
1
17
\.


--
-- Data for Name: petugas_paramedik; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.petugas_paramedik (paramedik_id) FROM stdin;
1
19
\.


--
-- Data for Name: pilihan_kondisi; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.pilihan_kondisi (pilihan_id, keterangan) FROM stdin;
1	Ya
2	Tidak
3	Tidak Tahu
\.


--
-- Data for Name: registrasi; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.registrasi (nik, no_datang, jenis_id, status_id, tanggal) FROM stdin;
2	1	1	5	2019-04-14 22:22:34.908908
3	1	1	9	2019-04-14 22:23:24.455135
4	1	3	6	2019-04-14 22:24:25.000853
1	1	1	4	2019-04-14 22:21:43.939475
3	2	2	11	2019-04-14 22:28:15.320972
1	2	4	7	2019-04-14 22:28:45.286517
4	2	4	5	2019-04-14 22:28:26.534409
2	2	2	4	2019-04-14 22:27:59.860326
\.


--
-- Data for Name: registrasi_event; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.registrasi_event (nik, no_datang, no_plat, waktu_mulai, waktu_selesai) FROM stdin;
2	2	BA1234AB	2019-04-15 09:00:00	2019-04-15 11:00:00
3	2	BA1234AB	2019-04-15 09:00:00	2019-04-15 11:00:00
4	2	BA1234AB	2019-04-15 09:00:00	2019-04-15 11:00:00
1	2	BA1234AB	2019-04-15 09:00:00	2019-04-15 11:00:00
\.


--
-- Data for Name: status_registrasi; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.status_registrasi (status_id, keterangan) FROM stdin;
1	Menunggu Pemeriksaan HB
2	Menunggu Pemeriksaan Paramedik
3	Menunggu Proses Donor
4	Berhasil
5	Gagal: Berat badan kurang ( < 45kg)
6	Gagal: Usia < 17 tahun
7	Gagal: Kadar HB Rendah ( <12,5 Gr/dl)
8	Gagal: Riwayat Medis Lain (Hipertensi, Hipotensi, Minum Obat, Pasca Operasi Kadar HB Tinggi >17Gr/dl)
11	Gagal: Alasan lain (gagal pengambilan darah)
10	Gagal: Riwayat bepergian (Daerah endemis malaria, negara dengan kasus HIV tinggi, negara dengan kasus sapi gila)
9	Gagal: Perilaku beresiko tinggi (Homoseksual, tato/tindik kurang dari 6 bulan, sex bebas, penasun, napi)
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (user_id, nama, jenis_kelamin, no_handphone, username, password) FROM stdin;
1	admin	pria	08123456789	admin	21232f297a57a5a743894a0e4a801fc3
17	Yoga	Pria	085274224215	rasakmarsawa	8e933201a769ead05cad04b3fad8adbb
18	Yogi	Pria	085274224216	rasakmarsawa2	8e933201a769ead05cad04b3fad8adbb
19	yogu	Pria	085274224217	rasakmarsawa3	8e933201a769ead05cad04b3fad8adbb
\.


--
-- Name: donor_nomor_kantung_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.donor_nomor_kantung_seq', 1, false);


--
-- Name: instansi_instansi_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.instansi_instansi_id_seq', 7, true);


--
-- Name: jenis_donor_jenis_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.jenis_donor_jenis_id_seq', 4, true);


--
-- Name: jenis_kantong_jkantong_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.jenis_kantong_jkantong_id_seq', 7, true);


--
-- Name: kondisi_kondisi_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.kondisi_kondisi_id_seq', 20, true);


--
-- Name: pilihan_kondisi_pilihan_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.pilihan_kondisi_pilihan_id_seq', 3, true);


--
-- Name: status_registrasi_status_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.status_registrasi_status_id_seq', 13, true);


--
-- Name: users_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_user_id_seq', 19, true);


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
-- Name: donor check_insert_donor; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER check_insert_donor BEFORE INSERT ON public.donor FOR EACH ROW EXECUTE PROCEDURE public.check_insert_donor();


--
-- Name: pemeriksaan_hb check_insert_pemeriksaan_hb; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER check_insert_pemeriksaan_hb BEFORE INSERT ON public.pemeriksaan_hb FOR EACH ROW EXECUTE PROCEDURE public.check_insert_pemeriksaan_hb();


--
-- Name: pemeriksaan_paramedik check_insert_pemeriksaan_paramedik; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER check_insert_pemeriksaan_paramedik BEFORE INSERT ON public.pemeriksaan_paramedik FOR EACH ROW EXECUTE PROCEDURE public.check_insert_pemeriksaan_paramedik();


--
-- Name: kerjasama_instansi kerjasama_instansi_onInsert; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER "kerjasama_instansi_onInsert" BEFORE INSERT ON public.kerjasama_instansi FOR EACH ROW EXECUTE PROCEDURE public.kerjasama_instansi_insert();


--
-- Name: registrasi oninsert_registrasi; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER oninsert_registrasi BEFORE INSERT ON public.registrasi FOR EACH ROW EXECUTE PROCEDURE public.registrasi_insert();


--
-- Name: pemeriksaan_hb update_status_to_2; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER update_status_to_2 AFTER INSERT ON public.pemeriksaan_hb FOR EACH ROW EXECUTE PROCEDURE public.update_status_to_2();


--
-- Name: pemeriksaan_paramedik update_status_to_3; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER update_status_to_3 AFTER INSERT ON public.pemeriksaan_paramedik FOR EACH ROW EXECUTE PROCEDURE public.update_status_to_3();


--
-- Name: donor update_status_to_4; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER update_status_to_4 AFTER INSERT ON public.donor FOR EACH ROW EXECUTE PROCEDURE public.update_status_to_4();


--
-- Name: donor donor_aftap_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.donor
    ADD CONSTRAINT donor_aftap_id_fkey FOREIGN KEY (aftap_id) REFERENCES public.petugas_aftap(aftap_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: donor donor_nik_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.donor
    ADD CONSTRAINT donor_nik_fkey FOREIGN KEY (nik, no_datang) REFERENCES public.pemeriksaan_paramedik(nik, no_datang) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: kerjasama_instansi kerjasama_instansi_instansi_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kerjasama_instansi
    ADD CONSTRAINT kerjasama_instansi_instansi_id_fkey FOREIGN KEY (instansi_id) REFERENCES public.instansi(instansi_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: kerjasama_instansi kerjasama_instansi_no_plat_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kerjasama_instansi
    ADD CONSTRAINT kerjasama_instansi_no_plat_fkey FOREIGN KEY (no_plat) REFERENCES public.kendaraan(no_plat) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: kondisi_registrasi kondisi_registrasi_kondisi_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kondisi_registrasi
    ADD CONSTRAINT kondisi_registrasi_kondisi_id_fkey FOREIGN KEY (kondisi_id) REFERENCES public.kondisi(kondisi_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: kondisi_registrasi kondisi_registrasi_nik_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kondisi_registrasi
    ADD CONSTRAINT kondisi_registrasi_nik_fkey FOREIGN KEY (nik, no_datang) REFERENCES public.registrasi(nik, no_datang) ON UPDATE CASCADE ON DELETE CASCADE;


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
    ADD CONSTRAINT petugas_aftap_aftap_id_fkey FOREIGN KEY (aftap_id) REFERENCES public.users(user_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: petugas_hb petugas_hb_hb_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.petugas_hb
    ADD CONSTRAINT petugas_hb_hb_id_fkey FOREIGN KEY (hb_id) REFERENCES public.users(user_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: petugas_paramedik petugas_paramedik_paramedik_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.petugas_paramedik
    ADD CONSTRAINT petugas_paramedik_paramedik_id_fkey FOREIGN KEY (paramedik_id) REFERENCES public.users(user_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: registrasi_event registrasi_event_nik_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.registrasi_event
    ADD CONSTRAINT registrasi_event_nik_fkey FOREIGN KEY (nik, no_datang) REFERENCES public.registrasi(nik, no_datang) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: registrasi_event registrasi_event_no_plat_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.registrasi_event
    ADD CONSTRAINT registrasi_event_no_plat_fkey FOREIGN KEY (no_plat, waktu_mulai, waktu_selesai) REFERENCES public.kerjasama_instansi(no_plat, waktu_mulai, waktu_selesai) ON UPDATE CASCADE ON DELETE CASCADE;


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


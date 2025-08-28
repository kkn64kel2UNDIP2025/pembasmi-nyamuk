-- WARNING: This schema is for context only and is not meant to be run.
-- Table order and constraints may not be valid for execution.

CREATE TABLE public.categories (
  id integer GENERATED ALWAYS AS IDENTITY NOT NULL,
  category_name character varying NOT NULL UNIQUE,
  CONSTRAINT categories_pkey PRIMARY KEY (id)
);
CREATE TABLE public.locations (
  id integer GENERATED ALWAYS AS IDENTITY NOT NULL,
  category_id smallint NOT NULL,
  latitude numeric NOT NULL,
  longitude numeric NOT NULL,
  description text,
  reported_at timestamp with time zone NOT NULL DEFAULT now(),
  status USER-DEFINED DEFAULT 'aktif'::status,
  resolve_at timestamp with time zone,
  level smallint NOT NULL,
  name character varying NOT NULL,
  phone character varying,
  evidence_image character varying,
  CONSTRAINT locations_pkey PRIMARY KEY (id),
  CONSTRAINT location_category_id_fkey FOREIGN KEY (category_id) REFERENCES public.categories(id)
);
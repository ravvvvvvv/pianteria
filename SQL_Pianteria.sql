create database pianteria;
use pianteria;

create table pianta (
id int auto_increment primary key,
nome nvarchar(30) not null,
nome_scientifico nvarchar(100) not null,
fiore int not null,
colore1 nvarchar(10) not null,
colore2 nvarchar(10) not null,
prezzo double not null,
quantità int not null,
adottabile int not null,
prezzo_adozione int not null
);

create table stagione(
id int auto_increment primary key,
nome nvarchar(9) not null
);

create table pianta_stagione(
id int auto_increment primary key,
id_pianta int not null,
id_stagione int not null
);

create table fornitore(
id int auto_increment primary key,
nome nvarchar(20) not null,
email nvarchar(30) not null,
telefono nvarchar(14) not null
);

create table rifornimento(
id int auto_increment primary key,
id_pianta int not null,
id_fornitore int not null,
quantità int not null,
data_ordine date not null,
data_arrivo date not null,
id_user int not null
);

create table pianta_ordine(
id int auto_increment primary key,
id_pianta int not null,
id_ordine int not null,
quantità int not null
);

create table ordine(
id int auto_increment primary key,
id_user int not null,
data_acquisto date not null,
data_ritiro date not null,
id_punto_ritiro int not null
);

create table punto_ritiro(
id int auto_increment primary key,
nome nvarchar(30) not null,
indirizzo nvarchar(100)
);

create table utente(
id int auto_increment primary key,
username nvarchar(30) not null,
email nvarchar(30) not null,
`password` nvarchar(30) not null,
livello_permessi int not null
);

alter table pianta_stagione
add foreign key (id_pianta) references pianta(id);

alter table pianta_stagione 
add foreign key (id_stagione) references stagione(id);

alter table rifornimento
add foreign key (id_pianta) references pianta(id);

alter table rifornimento
add foreign key (id_fornitore) references fornitore(id);

alter table rifornimento 
add foreign key (id_user) references utente(id);

alter table pianta_ordine
add foreign key (id_pianta) references pianta(id);

alter table pianta_ordine
add foreign key (id_ordine) references ordine(id);

alter table ordine
add foreign key (id_punto_ritiro) references punto_ritiro(id);

alter table ordine
add foreign key (id_user) references utente(id);

alter table pianta
add column inizio_raccolto date;

alter table pianta
add column fine_raccolto date;

create table adozioni(
id int auto_increment primary key,
id_pianta int not null,
id_user int not null,
quantity int not null,
punto_ritiro int not null
);

alter table adozioni
add foreign key (id_pianta) references pianta(id);

alter table adozioni
add foreign key (id_user) references utente(id);

alter table adozioni
add foreign key (punto_ritiro) references punto_ritiro(id);


alter table pianta 
add column stato_pianta int(1) not null;

alter table ordine 
add column stato int(4) not null;

alter table fornitore 
add column stato INT(1) not null;

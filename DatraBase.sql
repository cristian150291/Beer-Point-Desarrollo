
create table usuario.usuario (
	id serial,
	dni integer not null,
	nombre varchar(100) not null,
	apellido varchar(100) not null,
	mail varchar(100) not null,
	constraint pk_usuario primary key (id),
	constraint un_usuario unique (dni)
);

create table usuario.pws (
	id serial,
	id_usuario integer not null,
	us varchar (100) not null,
	pw varchar (100) not null,
	constraint pk_usuarios_pws primary key (id),
	constraint fk_usuario_usuario foreign key (id_usuario)
		references usuario.usuario (id)
);
import {
  Column,
  Entity,
  Index,
  JoinColumn,
  ManyToOne,
  OneToMany,
} from "typeorm";
import { Pets } from "./Pets";
import { Role } from "./Role";
import { UsersVeterinary } from "./UsersVeterinary";

@Index("users_email_unique", ["email"], { unique: true })
@Index("users_pkey", ["id"], { unique: true })
@Index("users_id_role_index", ["idRole"], {})
@Index("users_password_unique", ["password"], { unique: true })
@Index("users_phone_unique", ["phone"], { unique: true })
@Entity("users", { schema: "public" })
export class Users {
  @Column("integer", { primary: true, name: "id" })
  id: number;

  @Column("integer", { name: "id_role" })
  idRole: number;

  @Column("character varying", { name: "name", length: 255 })
  name: string;

  @Column("character varying", { name: "last_name", length: 255 })
  lastName: string;

  @Column("character varying", { name: "email", unique: true, length: 255 })
  email: string;

  @Column("bigint", { name: "phone", unique: true })
  phone: string;

  @Column("text", { name: "password", unique: true })
  password: string;

  @Column("text", { name: "avatar", nullable: true })
  avatar: string | null;

  @Column("text", { name: "address" })
  address: string;

  @Column("json", { name: "geo_location" })
  geoLocation: object;

  @Column("character varying", { name: "lenguaje", nullable: true, length: 30 })
  lenguaje: string | null;

  @Column("character varying", { name: "mod", length: 30 })
  mod: string;

  @Column("timestamp without time zone", { name: "updated_at", nullable: true })
  updatedAt: Date | null;

  @Column("timestamp without time zone", { name: "created_at" })
  createdAt: Date;

  @Column("timestamp without time zone", { name: "deleted_at", nullable: true })
  deletedAt: Date | null;

  @OneToMany(() => Pets, (pets) => pets.idUser)
  pets: Pets[];

  @ManyToOne(() => Role, (role) => role.users)
  @JoinColumn([{ name: "id_role", referencedColumnName: "id" }])
  idRole2: Role;

  @OneToMany(() => UsersVeterinary, (usersVeterinary) => usersVeterinary.idUser)
  usersVeterinaries: UsersVeterinary[];
}

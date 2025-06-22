import { Column, Entity, Index, OneToMany } from "typeorm";
import { Users } from "./Users";

@Index("role_pkey", ["id"], { unique: true })
@Entity("role", { schema: "public" })
export class Role {
  @Column("integer", { primary: true, name: "id" })
  id: number;

  @Column("character varying", { name: "name", length: 60 })
  name: string;

  @Column("text", { name: "permissions" })
  permissions: string;

  @Column("timestamp without time zone", { name: "created_at" })
  createdAt: Date;

  @Column("timestamp without time zone", { name: "updated_at", nullable: true })
  updatedAt: Date | null;

  @Column("timestamp without time zone", { name: "deleted_at", nullable: true })
  deletedAt: Date | null;

  @OneToMany(() => Users, (users) => users.idRole2)
  users: Users[];
}

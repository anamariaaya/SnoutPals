import { Column, Entity, Index, JoinColumn, ManyToOne } from "typeorm";
import { Users } from "./Users";
import { Veterinary } from "./Veterinary";

@Index("users_veterinary_pkey", ["id"], { unique: true })
@Entity("users_veterinary", { schema: "public" })
export class UsersVeterinary {
  @Column("integer", { primary: true, name: "id" })
  id: number;

  @Column("timestamp without time zone", { name: "created_at" })
  createdAt: Date;

  @Column("timestamp without time zone", { name: "updated_at", nullable: true })
  updatedAt: Date | null;

  @Column("timestamp without time zone", { name: "deleted_at", nullable: true })
  deletedAt: Date | null;

  @ManyToOne(() => Users, (users) => users.usersVeterinaries)
  @JoinColumn([{ name: "id_user", referencedColumnName: "id" }])
  idUser: Users;

  @ManyToOne(() => Veterinary, (veterinary) => veterinary.usersVeterinaries)
  @JoinColumn([{ name: "id_veterinary", referencedColumnName: "id" }])
  idVeterinary: Veterinary;
}

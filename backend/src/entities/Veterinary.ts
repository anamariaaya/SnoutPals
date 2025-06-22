import { Column, Entity, Index, OneToMany } from "typeorm";
import { Branches } from "./Branches";
import { UsersVeterinary } from "./UsersVeterinary";
import { VeterinarySchedules } from "./VeterinarySchedules";

@Index("veterinary_id_index", ["id"], {})
@Index("veterinary_pkey", ["id"], { unique: true })
@Index("veterinary_name_unique", ["name"], { unique: true })
@Index("veterinary_name_index", ["name"], {})
@Entity("veterinary", { schema: "public" })
export class Veterinary {
  @Column("integer", { primary: true, name: "id" })
  id: number;

  @Column("character varying", { name: "name", unique: true, length: 100 })
  name: string;

  @Column("text", { name: "Facebook" })
  facebook: string;

  @Column("text", { name: "Instagram" })
  instagram: string;

  @Column("text", { name: "x" })
  x: string;

  @Column("timestamp without time zone", { name: "created_at" })
  createdAt: Date;

  @Column("timestamp without time zone", { name: "updated_at", nullable: true })
  updatedAt: Date | null;

  @Column("timestamp without time zone", { name: "deleted_at", nullable: true })
  deletedAt: Date | null;

  @OneToMany(() => Branches, (branches) => branches.idVeterinary2)
  branches: Branches[];

  @OneToMany(
    () => UsersVeterinary,
    (usersVeterinary) => usersVeterinary.idVeterinary
  )
  usersVeterinaries: UsersVeterinary[];

  @OneToMany(
    () => VeterinarySchedules,
    (veterinarySchedules) => veterinarySchedules.idVeterinary
  )
  veterinarySchedules: VeterinarySchedules[];
}

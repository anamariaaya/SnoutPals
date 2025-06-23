import { Column, Entity, Index, OneToMany } from "typeorm";
import { Pets } from "./Pets";

@Index("breed_pkey", ["id"], { unique: true })
@Entity("breed", { schema: "public" })
export class Breed {
  @Column("integer", { primary: true, name: "id" })
  id: number;

  @Column("character varying", { name: "name", length: 60 })
  name: string;

  @Column("timestamp without time zone", { name: "created_at" })
  createdAt: Date;

  @Column("timestamp without time zone", { name: "updated_at", nullable: true })
  updatedAt: Date | null;

  @Column("timestamp without time zone", { name: "deleted_at", nullable: true })
  deletedAt: Date | null;

  @OneToMany(() => Pets, (pets) => pets.idBreed)
  pets: Pets[];
}

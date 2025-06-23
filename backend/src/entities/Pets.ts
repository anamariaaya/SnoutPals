import { Column, Entity, Index, JoinColumn, ManyToOne } from "typeorm";
import { AnimalType } from "./AnimalType";
import { Breed } from "./Breed";
import { Users } from "./Users";

@Index("pets_pkey", ["id"], { unique: true })
@Entity("pets", { schema: "public" })
export class Pets {
  @Column("integer", { primary: true, name: "id" })
  id: number;

  @Column("character varying", { name: "name", length: 255 })
  name: string;

  @Column("character varying", { name: "sex", length: 30 })
  sex: string;

  @Column("timestamp without time zone", { name: "created_at" })
  createdAt: Date;

  @Column("timestamp without time zone", { name: "updated_at", nullable: true })
  updatedAt: Date | null;

  @Column("timestamp without time zone", { name: "deleted_at", nullable: true })
  deletedAt: Date | null;

  @ManyToOne(() => AnimalType, (animalType) => animalType.pets)
  @JoinColumn([{ name: "id_animal_type", referencedColumnName: "id" }])
  idAnimalType: AnimalType;

  @ManyToOne(() => Breed, (breed) => breed.pets)
  @JoinColumn([{ name: "id_breed", referencedColumnName: "id" }])
  idBreed: Breed;

  @ManyToOne(() => Users, (users) => users.pets)
  @JoinColumn([{ name: "id_user", referencedColumnName: "id" }])
  idUser: Users;
}

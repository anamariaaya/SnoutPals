import { Column, Entity, Index, OneToMany } from "typeorm";
import { VeterinarySchedules } from "./VeterinarySchedules";

@Index("days_pkey", ["id"], { unique: true })
@Entity("days", { schema: "public" })
export class Days {
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

  @OneToMany(
    () => VeterinarySchedules,
    (veterinarySchedules) => veterinarySchedules.idDay
  )
  veterinarySchedules: VeterinarySchedules[];
}

import { Column, Entity, Index, JoinColumn, ManyToOne } from "typeorm";
import { Days } from "./Days";
import { Veterinary } from "./Veterinary";

@Index("veterinary_schedules_pkey", ["id"], { unique: true })
@Entity("veterinary_schedules", { schema: "public" })
export class VeterinarySchedules {
  @Column("integer", { primary: true, name: "id" })
  id: number;

  @Column("time without time zone", { name: "open_time" })
  openTime: string;

  @Column("time without time zone", { name: "close_time" })
  closeTime: string;

  @Column("timestamp without time zone", { name: "created_at" })
  createdAt: Date;

  @Column("timestamp without time zone", { name: "updated_at", nullable: true })
  updatedAt: Date | null;

  @Column("timestamp without time zone", { name: "deleted_at", nullable: true })
  deletedAt: Date | null;

  @ManyToOne(() => Days, (days) => days.veterinarySchedules)
  @JoinColumn([{ name: "id_day", referencedColumnName: "id" }])
  idDay: Days;

  @ManyToOne(() => Veterinary, (veterinary) => veterinary.veterinarySchedules)
  @JoinColumn([{ name: "id_veterinary", referencedColumnName: "id" }])
  idVeterinary: Veterinary;
}

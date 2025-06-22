import { Column, Entity, Index, JoinColumn, ManyToOne } from "typeorm";
import { Veterinary } from "./Veterinary";

@Index("branches_email_index", ["email"], {})
@Index("branches_id_index", ["id"], {})
@Index("branches_pkey", ["id"], { unique: true })
@Index("branches_id_veterinary_index", ["idVeterinary"], {})
@Entity("branches", { schema: "public" })
export class Branches {
  @Column("integer", { primary: true, name: "id" })
  id: number;

  @Column("integer", { name: "id_veterinary" })
  idVeterinary: number;

  @Column("text", { name: "avatar" })
  avatar: string;

  @Column("text", { name: "qr" })
  qr: string;

  @Column("character varying", { name: "email", length: 200 })
  email: string;

  @Column("text", { name: "address" })
  address: string;

  @Column("json", { name: "geo_location" })
  geoLocation: object;

  @Column("bigint", { name: "phone" })
  phone: string;

  @Column("text", { name: "wpp", nullable: true })
  wpp: string | null;

  @Column("text", { name: "telegram", nullable: true })
  telegram: string | null;

  @Column("timestamp without time zone", { name: "created_at" })
  createdAt: Date;

  @Column("timestamp without time zone", { name: "updated_at", nullable: true })
  updatedAt: Date | null;

  @Column("timestamp without time zone", { name: "deleted_at", nullable: true })
  deletedAt: Date | null;

  @ManyToOne(() => Veterinary, (veterinary) => veterinary.branches)
  @JoinColumn([{ name: "id_veterinary", referencedColumnName: "id" }])
  idVeterinary2: Veterinary;
}

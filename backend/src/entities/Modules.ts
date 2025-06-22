import { Column, Entity, Index } from "typeorm";

@Index("modules_pkey", ["id"], { unique: true })
@Entity("modules", { schema: "public" })
export class Modules {
  @Column("integer", { primary: true, name: "id" })
  id: number;

  @Column("character varying", { name: "slug", length: 60 })
  slug: string;

  @Column("timestamp without time zone", { name: "created_at" })
  createdAt: Date;

  @Column("timestamp without time zone", { name: "updated_at", nullable: true })
  updatedAt: Date | null;

  @Column("timestamp without time zone", { name: "deleted_at", nullable: true })
  deletedAt: Date | null;
}

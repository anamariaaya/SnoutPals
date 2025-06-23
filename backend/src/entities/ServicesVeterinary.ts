import { Column, Entity, Index, JoinColumn, ManyToOne } from "typeorm";
import { Services } from "./Services";

@Index("services_veterinary_pkey", ["id"], { unique: true })
@Entity("services_veterinary", { schema: "public" })
export class ServicesVeterinary {
  @Column("integer", { primary: true, name: "id" })
  id: number;

  @Column("integer", { name: "id_veterinary" })
  idVeterinary: number;

  @Column("timestamp without time zone", { name: "created_at" })
  createdAt: Date;

  @Column("timestamp without time zone", { name: "updated_at", nullable: true })
  updatedAt: Date | null;

  @Column("timestamp without time zone", { name: "deleted_at", nullable: true })
  deletedAt: Date | null;

  @ManyToOne(() => Services, (services) => services.servicesVeterinaries)
  @JoinColumn([{ name: "id_services", referencedColumnName: "id" }])
  idServices: Services;
}

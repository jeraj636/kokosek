import { Misel } from "../misel.js";
import { dobiConfig } from "../../config.js";
export async function dobiMisel(endpoint: string): Promise<Misel> {
  const parametri = new URLSearchParams(document.location.search);
  let t = parametri.get("t");
  const config = await dobiConfig();
  const podatki = await fetch(config.apiURL + endpoint + "/" + t);
  return (await podatki.json()) as Misel;
}

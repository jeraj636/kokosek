import { dobiConfig } from "../config.js";
interface Odgovor {
  info: string;
}
const prijavaGumb =
  (document.getElementById("priijavaBtn") as HTMLButtonElement) ??
  (() => {
    throw new Error("Ni prijavaBtn");
  })();
const upIme =
  (document.getElementById("upIme") as HTMLInputElement) ??
  (() => {
    throw new Error("Ni upIme");
  })();
const upGeslo =
  (document.getElementById("upGeslo") as HTMLInputElement) ??
  (() => {
    throw new Error("Ni upGeslo");
  })();
const config = await dobiConfig();

prijavaGumb.addEventListener("click", async () => {
  const podatki = await fetch(config.apiURL + "uporabnik/prijava/", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      Accept: "application/json",
    },
    body: JSON.stringify({ up_ime: upIme.value, up_geslo: upGeslo.value }),
  });
  const odgovor = (await podatki.json()) as Odgovor;
  console.log(odgovor.info);
});

import { dobiMisel } from "./dobi_misel.js";
export async function generiraj(tip_misli: string) {
  const misel = await dobiMisel(tip_misli);

  const naslov =
    document.getElementById("naslov") ??
    (() => {
      throw new Error("Napaka");
    })();
  const vsebina =
    document.getElementById("vsebina") ??
    (() => {
      throw new Error("Napaka");
    })();
  if (misel.besedilo === null) throw new Error("Napaka");
  naslov.innerHTML = misel.naslov;
  vsebina.innerHTML = misel.besedilo;
  const otroci = Array.from(vsebina.children);
  otroci.forEach((otrok) => {
    if (otrok.innerHTML.length > 0)
      otrok.classList = "boarder border-accent border-l-2";
  });
}

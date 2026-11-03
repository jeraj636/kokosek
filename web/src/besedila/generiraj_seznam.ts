import { dobiConfig } from "../config.js";
import { Misel } from "./misel.js";
async function dobiMisli(endpoint: string): Promise<Misel[]> {
  const config = await dobiConfig();
  const podatki = await fetch(config.apiURL + endpoint);
  return (await podatki.json()) as Misel[];
}
function narediLi(m: Misel, podstran: string): HTMLLIElement {
  const li = document.createElement("li");
  li.classList.add("list-row");
  li.appendChild(document.createElement("div"));
  li.children[0].classList.add("list-col-grow");

  li.children[0].appendChild(document.createElement("div"));

  li.children[0].children[0].appendChild(document.createElement("h3"));

  li.children[0].children[0].children[0].innerHTML = m.naslov;
  li.children[0].children[0].children[0].classList.add("text-accent");

  li.children[0].appendChild(document.createElement("div"));
  li.children[0].children[1].appendChild(document.createElement("h2"));

  const datumObjave = new Date(m.datum_objave);
  li.children[0].children[1].children[0].innerHTML =
    datumObjave.getDate() +
    ". " +
    datumObjave.getMonth() +
    ". " +
    datumObjave.getFullYear();

  li.appendChild(document.createElement("button"));
  ["btn", "btn-primary", "boarder", "border-accent", "border-1"].forEach(
    (c) => {
      li.children[1].classList.add(c);
    },
  );
  li.children[1].innerHTML = "Preberi";
  li.children[1].addEventListener("click", () => {
    window.location.href =
      window.location.toString() + podstran + "/?t=" + m.id_misli;
  });

  return li;
}
export async function generirajSeznam(endpoint: string, podstran: string) {
  const misli = await dobiMisli(endpoint);
  const seznam =
    document.getElementById("seznam") ??
    ((() => {
      throw new Error("Ni elementa z id: seznam");
    })() as HTMLUListElement);
  misli.forEach((misel) => {
    seznam.appendChild(narediLi(misel, podstran));
  });
}

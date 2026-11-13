// Pravice
const praviceBesedilo = document.getElementById(
  "pravice",
) as HTMLParagraphElement;
if (praviceBesedilo === null)
  throw new Error("Napka pri pridobivanju elementa z id: pravice");
praviceBesedilo.innerHTML =
  "&copy; " +
  String(new Date().getFullYear()) +
  " kokosek.si. Vse pravice pridržane.";

export interface Config {
  apiURL: string;
}
export async function dobiConfig(): Promise<Config> {
  const dat = await fetch("/config.json");

  console.log("Status:", dat.status);
  console.log("Content-Type:", dat.headers.get("content-type"));

  if (!dat.ok) throw new Error("napaka");
  return await dat.json();
}

export interface Config {
  apiURL: string;
}
export async function dobiConfig(): Promise<Config> {
  const dat = await fetch("/config.json");

  if (!dat.ok) throw new Error("napaka");
  return await dat.json();
}

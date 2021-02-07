export interface MissionLeaderboard {
  shortestEscape: Match | undefined;
  longestEscape: Match | undefined;
}

export interface Match {
  id: number;
  time: string;
  missionVersion: string;
  island: string;
  setting: string;
  playerCount: number;
  ending: string;
  tasks: Tasks;
  playTime: number;
  releaseVariation: string;
  serverName: string;
}

export interface Tasks {
  prisonEscaped: boolean;
  mapFound: boolean;
  comCenterHacked: boolean;
  exfiltrated: boolean;
}

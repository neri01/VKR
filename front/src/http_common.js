import Axios from "axios";

export const HTTP = Axios.create({
  baseURL: "https://pkdev.intres.team/rest/",
  headers: {
    Authorization: "Bearer IBFOH2p!FLwO*4zd0hXXb%Ag9",
  },
});

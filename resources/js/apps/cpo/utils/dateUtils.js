import { format } from "date-fns";

export function formatDate(date) {
  return date ? format(new Date(date), "MMMM dd, yyyy hh:mm:ss a") : "";
}

export function formatShortDate(date) {
  return date ? format(new Date(date), "MM/dd/yyyy hh:mm a") : "";
  // return date ? format(new Date(date), "MM/dd/yyyy") : "";
}

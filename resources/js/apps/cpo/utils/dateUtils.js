import { format } from "date-fns";

export function formatDate(date) {
  return date ? format(new Date(date), "MMMM dd, yyyy hh:mm:ss a") : "";
}

export function formatShortDate(date) {
  // return date ? format(new Date(date), "MM/dd/yyyy hh:mm a") : "";
  const today = new Date();
  const inputDate = new Date(date);
  const isToday = today.toDateString() === inputDate.toDateString();
  return isToday
    ? `Today ${format(inputDate, "hh:mm a")}`
    : format(inputDate, "MM/dd/yyyy hh:mm a");
  // return date ? format(new Date(date), "MM/dd/yyyy") : "";
}

export function formatDateTimeOnly(date) {
  return date ? format(new Date(date), "hh:mm a") : "";
}

export function isToday(date) {
  const today = new Date();
  const inputDate = new Date(date);
  return today.toDateString() === inputDate.toDateString();
}

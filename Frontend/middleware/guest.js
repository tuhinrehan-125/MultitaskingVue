export default function({ store, redirect }){
   if(store.getters["auth/athenticated"]){
      return redirect("/dashboard");
   }
}
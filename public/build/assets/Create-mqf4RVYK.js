import{x as b,e as a,o as l,a as t,s as n,f as d,z as m,u as r,t as u,b as p,w as f,g as x,S as g,p as y}from"./app-CTv7q664.js";import{_ as c}from"./AppLayout-3wmbgwo8.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const w={class:"max-w-2xl mx-auto bg-white shadow rounded-lg p-6"},_={key:0,class:"mt-1 text-sm text-red-600"},v={key:0,class:"mt-1 text-sm text-red-600"},k={class:"flex justify-between items-center"},B=Object.assign({layout:c},{__name:"Create",setup(V){const o=b({name:"",guard_name:"web"});function i(){o.post("/roles")}return(N,e)=>(l(),a("div",w,[e[6]||(e[6]=t("h1",{class:"text-3xl font-bold text-gray-800 mb-6"},"Crear Rol",-1)),t("form",{onSubmit:y(i,["prevent"]),class:"space-y-6"},[t("div",null,[e[2]||(e[2]=t("label",{for:"name",class:"block text-sm font-medium text-gray-700 mb-1"},"Nombre",-1)),n(t("input",{id:"name","onUpdate:modelValue":e[0]||(e[0]=s=>r(o).name=s),type:"text",class:"block w-full border border-gray-300 rounded-md px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none",placeholder:"Nombre del rol"},null,512),[[m,r(o).name]]),r(o).errors.name?(l(),a("p",_,u(r(o).errors.name),1)):d("",!0)]),t("div",null,[e[3]||(e[3]=t("label",{for:"guard_name",class:"block text-sm font-medium text-gray-700 mb-1"},"Guard",-1)),n(t("input",{id:"guard_name","onUpdate:modelValue":e[1]||(e[1]=s=>r(o).guard_name=s),type:"text",class:"block w-full border border-gray-300 rounded-md px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none",placeholder:"web, api, etc."},null,512),[[m,r(o).guard_name]]),r(o).errors.guard_name?(l(),a("p",v,u(r(o).errors.guard_name),1)):d("",!0)]),t("div",k,[p(r(g),{href:"/roles",class:"bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-4 py-2 rounded-md shadow"},{default:f(()=>e[4]||(e[4]=[x(" Volver ")])),_:1}),e[5]||(e[5]=t("button",{type:"submit",class:"bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-md shadow"}," Guardar ",-1))])],32)]))}});export{B as default};

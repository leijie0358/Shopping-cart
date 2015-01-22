using System;
using System.ServiceModel.Activation;
using System.Web;
using System.Web.Routing;

namespace IT_Open_API
{
    public class Global : HttpApplication
    {
        void Application_Start(object sender, EventArgs e)
        {
            RegisterRoutes();
        }

        private void RegisterRoutes()
        {
            // Edit the base address of Service1 by replacing the "Service1" string below
            RouteTable.Routes.Add(new ServiceRoute("Service1", new WebServiceHostFactory(), typeof(Service1)));
            RouteTable.Routes.Add(new ServiceRoute("AD/AD01", new WebServiceHostFactory(), typeof(IT_Open_API.AD01)));
            RouteTable.Routes.Add(new ServiceRoute("GIS/GIS01", new WebServiceHostFactory(), typeof(IT_Open_API.GIS01)));
            RouteTable.Routes.Add(new ServiceRoute("Exchange/Exchange01", new WebServiceHostFactory(), typeof(IT_Open_API.Exchange01)));
        }
    }
}

using System;
using System.Collections.Generic;
using System.Linq;
using System.ServiceModel;
using System.ServiceModel.Activation;
using System.ServiceModel.Web;
using System.Text;
using System.IO;

using System.DirectoryServices;

namespace IT_Open_API
{
    [ServiceContract]
    [AspNetCompatibilityRequirements(RequirementsMode = AspNetCompatibilityRequirementsMode.Allowed)]
    [ServiceBehavior(InstanceContextMode = InstanceContextMode.PerCall)]

    public class AD01
    {



        [WebGet(UriTemplate = "available_check")]
        public AD_ReturnItem available_check_get()
        {
            // TODO: Replace the current implementation to return a collection of SampleItem instances
            return new AD_ReturnItem() { dt_stamp = DateTime.Now.ToLongDateString()+" "+DateTime.Now.ToLongTimeString(), Str_Return = "Success" };
        }

        [WebInvoke(UriTemplate = "available_check", Method = "POST", ResponseFormat = WebMessageFormat.Json)]
        public AD_ReturnItem available_check_post(AD_InputItem01 InputItem)
        {
            string tmp_input = InputItem.Signature.ToString();
            DateTime tmp_datetime=DateTime.Now;
            string tmp_return = BaseClass.check_auth(InputItem.Signature.ToString(), "2");
            if (tmp_return.IndexOf("Success") >= 0)
            {
                BaseClass.WriteLog(tmp_return.Split('|')[1].ToString(), "2", "Success[" + tmp_input + "][" + tmp_return + "]", tmp_datetime);
                return new AD_ReturnItem() { dt_stamp = DateTime.Now.ToLongDateString() + " " + DateTime.Now.ToLongTimeString(), Str_Return = "Success" };
            }
            else
            {
                BaseClass.WriteLog("-1", "2", "Error[" + tmp_input + "][" + tmp_return + "]", tmp_datetime);
                return new AD_ReturnItem() { dt_stamp = DateTime.Now.ToLongDateString() + " " + DateTime.Now.ToLongTimeString(), Str_Return = tmp_return };
            }
        }

        [WebInvoke(UriTemplate = "is_exist_by_adaccount", Method = "POST", ResponseFormat = WebMessageFormat.Json)]
        public AD_ReturnItem is_exist_by_adaccount(AD_InputItem02 InputItem)
        {
            DateTime tmp_datetime = DateTime.Now;
            string tmp_input = InputItem.Signature.ToString() + "|" + InputItem.AD_Account.ToString() + "|" + InputItem.cn.ToString();
            string tmp_return = BaseClass.check_auth(InputItem.Signature.ToString(), "3");
            int tmp_count = 0;
            if (tmp_return.IndexOf("Success") >= 0)
            {
                if (InputItem.cn.ToUpper() == "CN1" || InputItem.cn.ToString() == "")
                {
                    using (DirectoryEntry deEntry = BaseClass.make_AD_Entry("cn1"))
                    {
                        using (SearchResultCollection ds = BaseClass.search_AD_object("sAMAccountName=" + InputItem.AD_Account.ToString(), deEntry))
                        {
                            tmp_count = tmp_count + ds.Count;
                        }
                    }
                }
                if (InputItem.cn.ToUpper() == "CN2" || InputItem.cn.ToString() == "")
                {
                    using (DirectoryEntry deEntry = BaseClass.make_AD_Entry("cn2"))
                    {
                        using (SearchResultCollection ds = BaseClass.search_AD_object("sAMAccountName=" + InputItem.AD_Account.ToString(), deEntry))
                        {
                            tmp_count = tmp_count + ds.Count;
                        }
                    }
                }
                if (InputItem.cn.ToUpper() == "CN3" || InputItem.cn.ToString() == "")
                {
                    using (DirectoryEntry deEntry = BaseClass.make_AD_Entry("cn3"))
                    {
                        using (SearchResultCollection ds = BaseClass.search_AD_object("sAMAccountName=" + InputItem.AD_Account.ToString(), deEntry))
                        {
                            tmp_count = tmp_count + ds.Count;
                        }
                    }
                }
                if (InputItem.cn.ToUpper() == "CN4" || InputItem.cn.ToString() == "")
                {
                    using (DirectoryEntry deEntry = BaseClass.make_AD_Entry("cn4"))
                    {
                        using (SearchResultCollection ds = BaseClass.search_AD_object("sAMAccountName=" + InputItem.AD_Account.ToString(), deEntry))
                        {
                            tmp_count = tmp_count + ds.Count;
                        }
                    }
                }
                if (InputItem.cn.ToUpper() == "CN5" || InputItem.cn.ToString() == "")
                {
                    using (DirectoryEntry deEntry = BaseClass.make_AD_Entry("cn5"))
                    {
                        using (SearchResultCollection ds = BaseClass.search_AD_object("sAMAccountName=" + InputItem.AD_Account.ToString(), deEntry))
                        {
                            tmp_count = tmp_count + ds.Count;
                        }
                    }
                }
                BaseClass.WriteLog(tmp_return.Split('|')[1].ToString(), "3", "Success[" + tmp_input + "][" + tmp_count.ToString() + "]", tmp_datetime);
                return new AD_ReturnItem() { dt_stamp = DateTime.Now.ToLongDateString() + " " + DateTime.Now.ToLongTimeString(), Str_Return = tmp_count.ToString() };
            }
            else {
                BaseClass.WriteLog("-1", "3", "Error[" + tmp_input + "][" + tmp_return + "]", tmp_datetime);
                return new AD_ReturnItem() { dt_stamp = DateTime.Now.ToLongDateString() + " " + DateTime.Now.ToLongTimeString(), Str_Return = tmp_return };
            }
            
        }
    }
}
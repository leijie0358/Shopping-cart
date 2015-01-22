using System;
using System.Collections.Generic;
using System.Linq;
using System.Runtime.Serialization;
using System.Text;

namespace IT_Open_API
{
    public class AD_ReturnItem
    {
        public string dt_stamp { get; set; }
        public string Str_Return { get; set; }
    }

    public class AD_InputItem01
    {
        public string Signature { get; set; }
    }

    public class AD_InputItem02
    {
        public string Signature { get; set; }
        public string AD_Account { get; set; }
        public string cn { get; set; }
    }
}
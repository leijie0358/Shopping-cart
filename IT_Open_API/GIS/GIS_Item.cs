using System;
using System.Collections.Generic;
using System.Linq;
using System.Runtime.Serialization;
using System.Text;

namespace IT_Open_API
{

    public class GIS_InputItem01
    {
        public string Str_Site { get; set; }
        public string s_pos_x { get; set; }
        public string s_pos_y { get; set; }
        public string d_pos_x { get; set; }
        public string d_pos_y { get; set; }
    }

    public class GIS_InputItem02
    {
        public string Str_Site { get; set; }
        public string search_key { get; set; }
    }





    public class GIS_ReturnItem
    {
        public string Str_Return { get; set; }
    }

    public class GIS_ReturnItem02
    {
        public string Str_Point { get; set; }
        public string Str_Status { get; set; }
    }

    public class GIS_ReturnItem03
    {
        public string Str_Key { get; set; }
        public string Str_Value { get; set; }
    }
}
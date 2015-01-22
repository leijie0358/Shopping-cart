using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace IT_Open_API
{
        public class Exchange_InputItem01
        {
            public string Str_Site { get; set; }
            public string Str_SearchKey { get; set; }
        }

        public class Exchange_InputItem02
        {
            public string Str_Site { get; set; }
            public string Str_Subject { get; set; }
            public string Str_Body { get; set; }
            public string Str_Start { get; set; }
            public string Str_Duration { get; set; }
            public string Str_MeetingRoom { get; set; }
            public string Str_Organizer { get; set; }
        }

        public class Exchange_InputItem03
        {
            public string Str_Site { get; set; }
            public string Str_Date { get; set; }
            public string Str_StartTime { get; set; }
            public string Str_Duration { get; set; }
            public string Str_MeetingRoom_List { get; set; }
            public string Str_MeetingRoom_Address { get; set; }
            public string Str_SearchKey { get; set; }
        }





        public class Exchange_ReturnItem01
        {
            public string Str_Name { get; set; }
            public string Str_Address { get; set; }
        }

        public class Exchange_ReturnItem02
        {
            public string App_Start_Time { get; set; }
            public string App_End_Time { get; set; }
            public string App_Organizer { get; set; }
            public string App_Subiect { get; set; }
        }

        public class Exchange_ReturnItem03
        {
            public string Str_Name { get; set; }
            public string Str_Address { get; set; }
            public string Str_Status { get; set; }
            public string Str_Detail { get; set; }
        }

        public class Exchange_ReturnItem04
        {
            public string Str_Result { get; set; }
        }

        public class Exchange_ReturnItem05
        {
            public string Str_Key { get; set; }
            public string Str_Value { get; set; }
        }

        public class Exchange_ReturnItem06
        {
            public string Str_Key { get; set; }
            public string Str_Value01 { get; set; }
            public string Str_Value02 { get; set; }
            public string Str_Value03 { get; set; }
            public string Str_Value04 { get; set; }
            public string Str_Value05 { get; set; }
        }
}
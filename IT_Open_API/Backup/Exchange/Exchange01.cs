using System;
using System.Collections.Generic;
using System.Linq;
using System.ServiceModel;
using System.ServiceModel.Activation;
using System.ServiceModel.Web;
using System.Text;
using System.IO;
using System.Data;

using Microsoft.Exchange;
using Microsoft.Exchange.WebServices;
using Microsoft.Exchange.WebServices.Data;
using System.Net;
using System.Net.Security;
using System.Security.Cryptography.X509Certificates;
using System.Configuration;
using System.Data.SqlClient;

namespace IT_Open_API
{
    [ServiceContract]
    [AspNetCompatibilityRequirements(RequirementsMode = AspNetCompatibilityRequirementsMode.Allowed)]
    [ServiceBehavior(InstanceContextMode = InstanceContextMode.PerCall)]

    public class Exchange01
    {
        private string str_admin = "";
        private string str_admin_pwd = "";
        private DateTime dt_now = DateTime.Now;
        private int active_start_time = 8;
        private int active_end_time = 20;

        [WebInvoke(UriTemplate = "Get_RoomList_bySite", Method = "POST", ResponseFormat = WebMessageFormat.Json)]
        public List<Exchange_ReturnItem01> Get_RoomList_bySite(Exchange_InputItem01 InputItem)
        {
            ServicePointManager.ServerCertificateValidationCallback = CertificateValidationCallBack;
            // 实例化ExchageService
            ExchangeService service = new ExchangeService(ExchangeVersion.Exchange2010_SP2);
            // 指定用户名，密码，和域名
            service.Credentials = new WebCredentials(str_admin, str_admin_pwd, "cn1.global.ctrip.com");
            // 指定Exchage服务的url地址
            service.Url = new Uri("http://shcas.cn1.global.ctrip.com/ews/exchange.asmx");
            
            EmailAddressCollection roomslist = service.GetRoomLists();
            List<Exchange_ReturnItem01> _list = new List<Exchange_ReturnItem01>();

            for (Int16 n = 0; n < roomslist.Count; n++)
            {
                string[] tmp_roomlist_array = roomslist[n].Name.Split(' ');
                if (tmp_roomlist_array[0].ToUpper() == InputItem.Str_SearchKey.ToUpper())
                { 
                    _list.Add(new Exchange_ReturnItem01() { Str_Name = roomslist[n].Name, Str_Address = roomslist[n].Address });
                }
            }
            
            return _list;
        }

        [WebInvoke(UriTemplate = "Get_UserList_byKey", Method = "POST", ResponseFormat = WebMessageFormat.Json)]
        public List<Exchange_ReturnItem01> Get_UserList_byKey(Exchange_InputItem01 InputItem)
        {
            SqlDbHelper _SqlDbHelper = new SqlDbHelper(ConfigurationManager.ConnectionStrings["ConnDB"].ConnectionString);
            SqlParameter[] paras = new SqlParameter[]{
                new SqlParameter("@search_key",InputItem.Str_SearchKey)
            };
            DataTable _dt = _SqlDbHelper.ExecuteDataTable("sp_get_userlist_bykey", System.Data.CommandType.StoredProcedure, paras);

            List<Exchange_ReturnItem01> _list = new List<Exchange_ReturnItem01>();

            for (Int16 n = 0; n < _dt.Rows.Count; n++)
            {
                _list.Add(new Exchange_ReturnItem01() { Str_Name = _dt.Rows[n][0].ToString(), Str_Address = _dt.Rows[n][1].ToString() });
            }

            return _list;
        }

        [WebInvoke(UriTemplate = "Get_MeetingRoom_byRoomList", Method = "POST", ResponseFormat = WebMessageFormat.Json)]
        public List<Exchange_ReturnItem01> Get_MeetingRoom_byRoomList(Exchange_InputItem01 InputItem)
        {
            ServicePointManager.ServerCertificateValidationCallback = CertificateValidationCallBack;
            // 实例化ExchageService
            ExchangeService service = new ExchangeService(ExchangeVersion.Exchange2010_SP2);
            // 指定用户名，密码，和域名
            service.Credentials = new WebCredentials(str_admin, str_admin_pwd, "cn1.global.ctrip.com");
            // 指定Exchage服务的url地址
            service.Url = new Uri("http://shcas.cn1.global.ctrip.com/ews/exchange.asmx");

            System.Collections.ObjectModel.Collection<EmailAddress> rooms = service.GetRooms(InputItem.Str_SearchKey);
            List<Exchange_ReturnItem01> _list = new List<Exchange_ReturnItem01>();

            for (Int16 i = 0; i < rooms.Count; i++)
            {
                _list.Add(new Exchange_ReturnItem01() { Str_Name = rooms[i].Name, Str_Address = rooms[i].Address });
                
            }

            return _list;
        }

        [WebInvoke(UriTemplate = "Get_MeetingRoom_CurrentStatus_byRoomList", Method = "POST", ResponseFormat = WebMessageFormat.Json)]
        public List<Exchange_ReturnItem03> Get_MeetingRoom_CurrentStatus_byRoomList(Exchange_InputItem01 InputItem)
        {
            DateTime searchdtStart = dt_now;
            DateTime searchdtEnd = dt_now.AddMinutes(1);

            ServicePointManager.ServerCertificateValidationCallback = CertificateValidationCallBack;
            // 实例化ExchageService
            ExchangeService service = new ExchangeService(ExchangeVersion.Exchange2010_SP2);
            // 指定用户名，密码，和域名
            service.Credentials = new WebCredentials(str_admin, str_admin_pwd, "cn1.global.ctrip.com");
            // 指定Exchage服务的url地址
            service.Url = new Uri("http://shcas.cn1.global.ctrip.com/ews/exchange.asmx");

            System.Collections.ObjectModel.Collection<EmailAddress> rooms = service.GetRooms(InputItem.Str_SearchKey);
            List<Exchange_ReturnItem03> _list = new List<Exchange_ReturnItem03>();

            for (Int16 i = 0; i < rooms.Count; i++)
            {
                CalendarView calendarView = new CalendarView(searchdtStart, searchdtEnd);
                calendarView.PropertySet = new PropertySet(BasePropertySet.FirstClassProperties);

                Mailbox mailbox = new Mailbox(rooms[i].Address);
                FolderId calendarFolder = new FolderId(WellKnownFolderName.Calendar, mailbox);
                FindItemsResults<Appointment> findResults = service.FindAppointments(calendarFolder, calendarView);
                if (findResults.TotalCount == 0)
                {
                    _list.Add(new Exchange_ReturnItem03() { Str_Name = rooms[i].Name, Str_Address = rooms[i].Address, Str_Status = "Free", Str_Detail="" });
                }
                else {
                    _list.Add(new Exchange_ReturnItem03() { Str_Name = rooms[i].Name, Str_Address = rooms[i].Address, Str_Status = "Busy", Str_Detail = findResults.Items[0].Start.ToShortTimeString() + "-" + findResults.Items[0].End.ToShortTimeString() + "    " + findResults.Items[0].Subject.ToString() });
                }
            }

            return _list;
        }

        [WebInvoke(UriTemplate = "Get_Appointment_Daily_byMeetingRoom", Method = "POST", ResponseFormat = WebMessageFormat.Json)]
        public List<Exchange_ReturnItem02> Get_Appointment_Daily_byMeetingRoom(Exchange_InputItem01 InputItem)
        {
            DateTime searchdtStart = dt_now.Date;
            DateTime searchdtEnd = dt_now.Date.AddDays(1);

            ServicePointManager.ServerCertificateValidationCallback = CertificateValidationCallBack;
            // 实例化ExchageService
            ExchangeService service = new ExchangeService(ExchangeVersion.Exchange2010_SP2);
            // 指定用户名，密码，和域名
            service.Credentials = new WebCredentials(str_admin, str_admin_pwd, "cn1.global.ctrip.com");
            // 指定Exchage服务的url地址
            service.Url = new Uri("http://shcas.cn1.global.ctrip.com/ews/exchange.asmx");

            List<Exchange_ReturnItem02> _list = new List<Exchange_ReturnItem02>();

            CalendarFolder calendarfolder = (CalendarFolder)Folder.Bind(service, WellKnownFolderName.Calendar);
            if (calendarfolder != null)
            {
                //CalendarView calendarView = new CalendarView(searchdtStart, searchdtEnd);
                CalendarView calendarView = new CalendarView(searchdtStart, searchdtEnd);
                calendarView.PropertySet = new PropertySet(BasePropertySet.FirstClassProperties);

                Mailbox mailbox = new Mailbox(InputItem.Str_SearchKey);
                FolderId calendarFolder = new FolderId(WellKnownFolderName.Calendar, mailbox);
                FindItemsResults<Appointment> findResults = service.FindAppointments(calendarFolder, calendarView);
                if (findResults.TotalCount != 0)
                {
                    PropertySet detailedPropertySet = new PropertySet(BasePropertySet.FirstClassProperties, AppointmentSchema.Recurrence);
                    service.LoadPropertiesForItems(from Item item in findResults select item, detailedPropertySet);
                    foreach (Appointment item in findResults.Items)
                    {
                        _list.Add(new Exchange_ReturnItem02() {
                            App_Start_Time = item.Start.ToShortTimeString(),
                            App_End_Time = item.End.ToShortTimeString(),
                            App_Organizer = item.Organizer.Name.ToString(),
                            App_Subiect=item.Subject.ToString()
                        });
                    }
                }
            }

            return _list;
        }

        [WebInvoke(UriTemplate = "Book_Appointment", Method = "POST", ResponseFormat = WebMessageFormat.Json)]
        public Exchange_ReturnItem04 Book_Appointment(Exchange_InputItem02 InputItem)
        {
            try {
                DateTime tmp_dt_start=new DateTime();
                tmp_dt_start = DateTime.Parse(InputItem.Str_Start);

                ServicePointManager.ServerCertificateValidationCallback = CertificateValidationCallBack;
                // 实例化ExchageService
                ExchangeService service = new ExchangeService(ExchangeVersion.Exchange2010_SP2);
                // 指定用户名，密码，和域名
                service.Credentials = new WebCredentials(str_admin, str_admin_pwd, "cn1.global.ctrip.com");
                // 指定Exchage服务的url地址
                service.Url = new Uri("http://shcas.cn1.global.ctrip.com/ews/exchange.asmx");

                Appointment appointment = new Appointment(service);
                appointment.Subject = InputItem.Str_Subject;
                appointment.Body = InputItem.Str_Body;
                appointment.Start = tmp_dt_start;

                appointment.End = tmp_dt_start.AddHours(Convert.ToDouble(InputItem.Str_Duration));
                appointment.Location = InputItem.Str_MeetingRoom;
                appointment.RequiredAttendees.Add(InputItem.Str_MeetingRoom);
                appointment.RequiredAttendees.Add(InputItem.Str_Organizer);
                
                appointment.Save(SendInvitationsMode.SendToAllAndSaveCopy);
                return new Exchange_ReturnItem04() { Str_Result = "Success" };
            }
            catch(Exception ex){
                return new Exchange_ReturnItem04() { Str_Result = "ERR:"+ex.Message };
            }
        }

        [WebInvoke(UriTemplate = "Get_MeetingRoom_by_Duration", Method = "POST", ResponseFormat = WebMessageFormat.Json)]
        public List<Exchange_ReturnItem01> Get_MeetingRoom_by_Duration(Exchange_InputItem03 InputItem)
        {
            DataTable tmp_dt = get_dt_free_meetingroom(InputItem.Str_Date, InputItem.Str_MeetingRoom_List,"");
            DataTable newdt = new DataTable();
            newdt = tmp_dt.Clone(); 
            DataRow[] rows = tmp_dt.Select("next_duration>='" + InputItem.Str_Duration+"'");
            foreach (DataRow row in rows)  // 将查询的结果添加到dt中
            {
                newdt.Rows.Add(row.ItemArray); 
            }
            DataView dataView = newdt.DefaultView;
            DataTable dataTableDistinct = dataView.ToTable(true, "room_address", "room_name");

            List<Exchange_ReturnItem01> _list = new List<Exchange_ReturnItem01>();
            for (Int16 i = 0; i < dataTableDistinct.Rows.Count; i++)
            { 
                _list.Add(new Exchange_ReturnItem01() {
                            Str_Name = dataTableDistinct.Rows[i]["room_name"].ToString(),
                            Str_Address = dataTableDistinct.Rows[i]["room_address"].ToString()
                        });
            }
            return _list;
        }

        [WebInvoke(UriTemplate = "Get_StartTime_by_Duration_MeetingRoom", Method = "POST", ResponseFormat = WebMessageFormat.Json)]
        public List<Exchange_ReturnItem01> Get_StartTime_by_Duration_MeetingRoom(Exchange_InputItem03 InputItem)
        {
            DataTable tmp_dt = get_dt_free_meetingroom(InputItem.Str_Date, InputItem.Str_MeetingRoom_List, InputItem.Str_MeetingRoom_Address);
            DataTable newdt = new DataTable();
            DataRow[] rows = tmp_dt.Select("next_duration>='" + InputItem.Str_Duration+"'");

            List<Exchange_ReturnItem01> _list = new List<Exchange_ReturnItem01>();
            foreach (DataRow row in rows)  // 将查询的结果添加到dt中
            {
                _list.Add(new Exchange_ReturnItem01()
                {
                    Str_Name = row["next_time"].ToString(),
                    Str_Address = row["next_time"].ToString()
                });
                int n = (Convert.ToInt16(row["next_duration"].ToString()) - Convert.ToInt16(InputItem.Str_Duration))*2;
                DateTime tmp_datetime = DateTime.Parse(InputItem.Str_Date + " " + row["next_time"].ToString());
                for (Int16 i = 1; i <= n; i++)
                {
                    _list.Add(new Exchange_ReturnItem01()
                    {
                        Str_Name = tmp_datetime.AddMinutes(30*i).ToShortTimeString(),
                        Str_Address = tmp_datetime.AddMinutes(30 * i).ToShortTimeString()
                    });
                }
            }

            return _list;
        }

        [WebInvoke(UriTemplate = "Get_MeetingRoom_by_Duration_StartTime", Method = "POST", ResponseFormat = WebMessageFormat.Json)]
        public List<Exchange_ReturnItem01> Get_MeetingRoom_by_Duration_StartTime(Exchange_InputItem03 InputItem)
        {
            DataTable tmp_dt = get_dt_free_meetingroom(InputItem.Str_Date, InputItem.Str_MeetingRoom_List, "");
            DataTable newdt = new DataTable();
            DataRow[] rows = tmp_dt.Select("next_duration>='" + InputItem.Str_Duration + "' and next_time='" + InputItem.Str_StartTime + "'");

            List<Exchange_ReturnItem01> _list = new List<Exchange_ReturnItem01>();
            foreach (DataRow row in rows)  // 将查询的结果添加到dt中
            {
                _list.Add(new Exchange_ReturnItem01()
                {
                    Str_Name = row["room_name"].ToString(),
                    Str_Address = row["room_address"].ToString()
                });
            }
            return _list;
        }

        [WebInvoke(UriTemplate = "Get_FreeNow_Duration_by_MeetingRoom", Method = "POST", ResponseFormat = WebMessageFormat.Json)]
        public List<Exchange_ReturnItem01> Get_FreeNow_Duration_by_MeetingRoom(Exchange_InputItem03 InputItem)
        {
            List<Exchange_ReturnItem01> _list = new List<Exchange_ReturnItem01>();
            for (int i = 1; i <= 4; i++)
            {
                if (check_free_meetingroom(InputItem.Str_MeetingRoom_Address, InputItem.Str_Date + " " + InputItem.Str_StartTime, 0.5 * i))
                { 
                    _list.Add(new Exchange_ReturnItem01()
                    {
                        Str_Name = (0.5 * i).ToString(),
                        Str_Address = (0.5 * i).ToString()
                    });
                }
            }
            return _list;
        }

        [WebInvoke(UriTemplate = "Get_FreeNow_MeetingRoom_by_StartTime_Duration", Method = "POST", ResponseFormat = WebMessageFormat.Json)]
        public List<Exchange_ReturnItem01> Get_FreeNow_MeetingRoom_by_StartTime_Duration(Exchange_InputItem03 InputItem)
        {
            SqlDbHelper _SqlDbHelper = new SqlDbHelper(ConfigurationManager.ConnectionStrings["ConnDB_GIS"].ConnectionString);
            SqlParameter[] paras = new SqlParameter[]{
                new SqlParameter("@p_site",InputItem.Str_Site),
                new SqlParameter("@p_search_key",InputItem.Str_SearchKey)
            };
            DataTable _dt = _SqlDbHelper.ExecuteDataTable("sp_get_MeetingRoom_List_for_Appointment", System.Data.CommandType.StoredProcedure, paras);



            List<Exchange_ReturnItem01> _list = new List<Exchange_ReturnItem01>();
            ServicePointManager.ServerCertificateValidationCallback = CertificateValidationCallBack;
            // 实例化ExchageService
            ExchangeService service = new ExchangeService(ExchangeVersion.Exchange2010_SP2);
            // 指定用户名，密码，和域名
            service.Credentials = new WebCredentials(str_admin, str_admin_pwd, "cn1.global.ctrip.com");
            // 指定Exchage服务的url地址
            service.Url = new Uri("http://shcas.cn1.global.ctrip.com/ews/exchange.asmx");

            CalendarFolder calendarfolder = (CalendarFolder)Folder.Bind(service, WellKnownFolderName.Calendar);
            //System.Collections.ObjectModel.Collection<EmailAddress> rooms = service.GetRooms(InputItem.Str_MeetingRoom_List);
            //for (Int16 i = 0; i < rooms.Count; i++)
            //{
            //    if (check_free_meetingroom(rooms[i].Address, InputItem.Str_Date + " " + InputItem.Str_StartTime, Convert.ToDouble(InputItem.Str_Duration)))
            //    {
            //        _list.Add(new Exchange_ReturnItem01()
            //        {
            //            Str_Name = rooms[i].Name,
            //            Str_Address = rooms[i].Address
            //        });
            //    }
            //}
                foreach(DataRow tmp_row in _dt.Rows)
                {
                    if (check_free_meetingroom(tmp_row["room_address"].ToString(), InputItem.Str_Date + " " + InputItem.Str_StartTime, Convert.ToDouble(InputItem.Str_Duration)))
                    {
                        _list.Add(new Exchange_ReturnItem01()
                        {
                            Str_Name = tmp_row["room_name"].ToString(),
                            Str_Address = tmp_row["room_address"].ToString()
                        });
                    }
                }
            return _list;
        }

        [WebInvoke(UriTemplate = "Get_MeetingRoom_Resource_List", Method = "POST", ResponseFormat = WebMessageFormat.Json)]
        public List<Exchange_ReturnItem01> Get_MeetingRoom_Resource_List()
        {
            SqlDbHelper _SqlDbHelper = new SqlDbHelper(ConfigurationManager.ConnectionStrings["ConnDB_GIS"].ConnectionString);
            //SqlParameter[] paras = new SqlParameter[]{
            //    new SqlParameter("@p_site",InputItem.Str_Site),
            //    new SqlParameter("@p_search_key",InputItem.Str_SearchKey)
            //};
            DataTable _dt = _SqlDbHelper.ExecuteDataTable("sp_get_MeetingRoom_List_Resource_List", System.Data.CommandType.StoredProcedure);

            List<Exchange_ReturnItem01> _list = new List<Exchange_ReturnItem01>();
            foreach (DataRow tmp_row in _dt.Rows)
            {
                _list.Add(new Exchange_ReturnItem01()
                {
                    Str_Name = tmp_row["node_desc"].ToString(),
                    Str_Address = tmp_row["node_id"].ToString()
                });
            }

            return _list;
        }

        [WebInvoke(UriTemplate = "Load_MeetingRoom_DetailInfo_by_Address", Method = "POST", ResponseFormat = WebMessageFormat.Json)]
        public List<Exchange_ReturnItem05> Load_MeetingRoom_DetailInfo_by_Address(Exchange_InputItem01 InputItem)
        {
            List<Exchange_ReturnItem05> _list = new List<Exchange_ReturnItem05>();
            SqlDbHelper _SqlDbHelper = new SqlDbHelper(ConfigurationManager.ConnectionStrings["ConnDB_GIS"].ConnectionString);
            SqlParameter[] paras = new SqlParameter[]{
                new SqlParameter("@search_key",InputItem.Str_SearchKey)
            };
            DataTable _dt = _SqlDbHelper.ExecuteDataTable("sp_get_MeetingRoom_DetailInfo", System.Data.CommandType.StoredProcedure, paras);
            if (_dt.Rows.Count > 0)
            {
                _list.Add(new Exchange_ReturnItem05() { Str_Key = "room_address", Str_Value = _dt.Rows[0]["room_address"].ToString() });
                _list.Add(new Exchange_ReturnItem05() { Str_Key = "会议室名称", Str_Value = _dt.Rows[0]["room_name"].ToString() });
                _list.Add(new Exchange_ReturnItem05() { Str_Key = "地址", Str_Value = _dt.Rows[0]["room_location"].ToString() });
                _list.Add(new Exchange_ReturnItem05() { Str_Key = "容量", Str_Value = _dt.Rows[0]["room_capacity"].ToString() });
                _list.Add(new Exchange_ReturnItem05() { Str_Key = _dt.Rows[0]["rs00"].ToString().Split('|')[0].ToString(), Str_Value = _dt.Rows[0]["rs00"].ToString().Split('|')[1].ToString() });
                _list.Add(new Exchange_ReturnItem05() { Str_Key = _dt.Rows[0]["rs01"].ToString().Split('|')[0].ToString(), Str_Value = _dt.Rows[0]["rs01"].ToString().Split('|')[1].ToString() });
                _list.Add(new Exchange_ReturnItem05() { Str_Key = _dt.Rows[0]["rs02"].ToString().Split('|')[0].ToString(), Str_Value = _dt.Rows[0]["rs02"].ToString().Split('|')[1].ToString() });
                _list.Add(new Exchange_ReturnItem05() { Str_Key = _dt.Rows[0]["rs03"].ToString().Split('|')[0].ToString(), Str_Value = _dt.Rows[0]["rs03"].ToString().Split('|')[1].ToString() });
                _list.Add(new Exchange_ReturnItem05() { Str_Key = _dt.Rows[0]["rs04"].ToString().Split('|')[0].ToString(), Str_Value = _dt.Rows[0]["rs04"].ToString().Split('|')[1].ToString() });
                _list.Add(new Exchange_ReturnItem05() { Str_Key = _dt.Rows[0]["rs05"].ToString().Split('|')[0].ToString(), Str_Value = _dt.Rows[0]["rs05"].ToString().Split('|')[1].ToString() });
                _list.Add(new Exchange_ReturnItem05() { Str_Key = _dt.Rows[0]["rs06"].ToString().Split('|')[0].ToString(), Str_Value = _dt.Rows[0]["rs06"].ToString().Split('|')[1].ToString() });
                _list.Add(new Exchange_ReturnItem05() { Str_Key = _dt.Rows[0]["rs07"].ToString().Split('|')[0].ToString(), Str_Value = _dt.Rows[0]["rs07"].ToString().Split('|')[1].ToString() });
                _list.Add(new Exchange_ReturnItem05() { Str_Key = _dt.Rows[0]["rs08"].ToString().Split('|')[0].ToString(), Str_Value = _dt.Rows[0]["rs08"].ToString().Split('|')[1].ToString() });
                _list.Add(new Exchange_ReturnItem05() { Str_Key = _dt.Rows[0]["rs09"].ToString().Split('|')[0].ToString(), Str_Value = _dt.Rows[0]["rs09"].ToString().Split('|')[1].ToString() });
                _list.Add(new Exchange_ReturnItem05() { Str_Key = _dt.Rows[0]["rs10"].ToString().Split('|')[0].ToString(), Str_Value = _dt.Rows[0]["rs10"].ToString().Split('|')[1].ToString() });
                _list.Add(new Exchange_ReturnItem05() { Str_Key = _dt.Rows[0]["rs11"].ToString().Split('|')[0].ToString(), Str_Value = _dt.Rows[0]["rs11"].ToString().Split('|')[1].ToString() });
                _list.Add(new Exchange_ReturnItem05() { Str_Key = _dt.Rows[0]["rs12"].ToString().Split('|')[0].ToString(), Str_Value = _dt.Rows[0]["rs12"].ToString().Split('|')[1].ToString() });
                _list.Add(new Exchange_ReturnItem05() { Str_Key = _dt.Rows[0]["rs13"].ToString().Split('|')[0].ToString(), Str_Value = _dt.Rows[0]["rs13"].ToString().Split('|')[1].ToString() });
                _list.Add(new Exchange_ReturnItem05() { Str_Key = _dt.Rows[0]["rs14"].ToString().Split('|')[0].ToString(), Str_Value = _dt.Rows[0]["rs14"].ToString().Split('|')[1].ToString() });
                _list.Add(new Exchange_ReturnItem05() { Str_Key = _dt.Rows[0]["rs15"].ToString().Split('|')[0].ToString(), Str_Value = _dt.Rows[0]["rs15"].ToString().Split('|')[1].ToString() });
                _list.Add(new Exchange_ReturnItem05() { Str_Key = _dt.Rows[0]["rs16"].ToString().Split('|')[0].ToString(), Str_Value = _dt.Rows[0]["rs16"].ToString().Split('|')[1].ToString() });
                _list.Add(new Exchange_ReturnItem05() { Str_Key = _dt.Rows[0]["rs17"].ToString().Split('|')[0].ToString(), Str_Value = _dt.Rows[0]["rs17"].ToString().Split('|')[1].ToString() });
                _list.Add(new Exchange_ReturnItem05() { Str_Key = _dt.Rows[0]["rs18"].ToString().Split('|')[0].ToString(), Str_Value = _dt.Rows[0]["rs18"].ToString().Split('|')[1].ToString() });
                _list.Add(new Exchange_ReturnItem05() { Str_Key = _dt.Rows[0]["rs19"].ToString().Split('|')[0].ToString(), Str_Value = _dt.Rows[0]["rs19"].ToString().Split('|')[1].ToString() });
            }
            return _list;

        }

        private Boolean check_free_meetingroom(string p_roomaddress, string p_date, double p_Duration)
        {
            DateTime searchdtStart = DateTime.Parse(p_date);
            DateTime searchdtEnd = DateTime.Parse(p_date).AddHours(p_Duration);

            ServicePointManager.ServerCertificateValidationCallback = CertificateValidationCallBack;
            // 实例化ExchageService
            ExchangeService service = new ExchangeService(ExchangeVersion.Exchange2010_SP2);
            // 指定用户名，密码，和域名
            service.Credentials = new WebCredentials(str_admin, str_admin_pwd, "cn1.global.ctrip.com");
            // 指定Exchage服务的url地址
            service.Url = new Uri("http://shcas.cn1.global.ctrip.com/ews/exchange.asmx");

            CalendarFolder calendarfolder = (CalendarFolder)Folder.Bind(service, WellKnownFolderName.Calendar);
            if (calendarfolder != null)
            {
                CalendarView calendarView = new CalendarView(searchdtStart, searchdtEnd);
                calendarView.PropertySet = new PropertySet(BasePropertySet.FirstClassProperties);

                Mailbox mailbox = new Mailbox(p_roomaddress);
                FolderId calendarFolder = new FolderId(WellKnownFolderName.Calendar, mailbox);
                FindItemsResults<Appointment> findResults = service.FindAppointments(calendarFolder, calendarView);
                if (findResults.TotalCount == 0)
                {
                    return true;
                }
                else {
                    return false;
                }
            }
            return false;
        }

        private DataTable get_dt_free_meetingroom(string p_date,string p_roomlist,string p_roomaddress)
        {
            DataTable dt_result = new DataTable();
            dt_result.Columns.Add("room_address");
            dt_result.Columns.Add("room_name");
            dt_result.Columns.Add("next_time");
            dt_result.Columns.Add("next_duration");

            ServicePointManager.ServerCertificateValidationCallback = CertificateValidationCallBack;
            // 实例化ExchageService
            ExchangeService service = new ExchangeService(ExchangeVersion.Exchange2010_SP2);
            // 指定用户名，密码，和域名
            service.Credentials = new WebCredentials(str_admin, str_admin_pwd, "cn1.global.ctrip.com");
            // 指定Exchage服务的url地址
            service.Url = new Uri("http://shcas.cn1.global.ctrip.com/ews/exchange.asmx");



            
            DateTime searchdtNow = DateTime.Now;

            CalendarFolder calendarfolder = (CalendarFolder)Folder.Bind(service, WellKnownFolderName.Calendar);
            System.Collections.ObjectModel.Collection<EmailAddress> rooms = service.GetRooms(p_roomlist);
            for (Int16 i = 0; i < rooms.Count; i++)
            {
                if (rooms[i].Address == p_roomaddress || p_roomaddress == "")
                { 
                    DateTime searchdtStart = DateTime.Parse(p_date).AddHours(active_start_time);
                    DateTime searchdtEnd = DateTime.Parse(p_date).AddHours(active_end_time);
                    if (searchdtNow.Minute >= 0 && searchdtNow.Minute < 30)
                    {
                        searchdtNow=searchdtNow.AddMinutes(30 - searchdtNow.Minute);
                    }
                    else {
                        searchdtNow=searchdtNow.AddMinutes(60 - searchdtNow.Minute);
                    }
                    if (searchdtStart < searchdtNow)
                    {
                        searchdtStart = searchdtNow;
                    }
                    while (searchdtStart < searchdtEnd)
                    {
                        CalendarView calendarView = new CalendarView(searchdtStart, searchdtEnd);
                        calendarView.PropertySet = new PropertySet(BasePropertySet.FirstClassProperties);
                        Mailbox mailbox = new Mailbox(rooms[i].Address);
                        FolderId calendarFolder = new FolderId(WellKnownFolderName.Calendar, mailbox);
                        FindItemsResults<Appointment> findResults = service.FindAppointments(calendarFolder, calendarView);
                        if (findResults.TotalCount == 0)
                        {
                            DataRow tmp_row = dt_result.NewRow();
                            tmp_row["room_address"] = rooms[i].Address;
                            tmp_row["room_name"] = rooms[i].Name;
                            tmp_row["next_time"] = searchdtStart.ToShortTimeString();
                            tmp_row["next_duration"] = ((TimeSpan)(searchdtEnd - DateTime.Parse(p_date + " " + searchdtStart.ToShortTimeString()))).TotalHours;
                            dt_result.Rows.Add(tmp_row);
                            searchdtStart = searchdtEnd;
                        }
                        else {
                            if (findResults.Items[0].Start <= searchdtStart)
                            {
                                if (findResults.Items[0].End < searchdtEnd)
                                {
                                    searchdtStart = findResults.Items[0].End;//--------------------1
                                }
                                else {
                                    searchdtStart = searchdtEnd;//--------------------2
                                }
                            }
                            else {
                                DataRow tmp_row = dt_result.NewRow();
                                tmp_row["room_address"] = rooms[i].Address;
                                tmp_row["room_name"] = rooms[i].Name;
                                tmp_row["next_time"] = searchdtStart.ToShortTimeString();
                                tmp_row["next_duration"] = ((TimeSpan)(findResults.Items[0].End - DateTime.Parse(p_date+" "+searchdtStart.ToShortTimeString()))).TotalHours;
                                dt_result.Rows.Add(tmp_row);

                                if (findResults.Items[0].End < searchdtEnd)
                                {
                                    searchdtStart = findResults.Items[0].End;//--------------------3
                                }
                                else {
                                    searchdtStart = searchdtEnd;//--------------------4
                                }
                            }
                        }
                        searchdtStart = searchdtStart.AddSeconds(59);
                    }
                }
            }
            return dt_result;
        }

        [WebInvoke(UriTemplate = "Get_DeptList_byKey", Method = "POST", ResponseFormat = WebMessageFormat.Json)]
        public List<Exchange_ReturnItem01> Get_DeptList_byKey(Exchange_InputItem01 InputItem)
        {
            SqlDbHelper _SqlDbHelper = new SqlDbHelper(ConfigurationManager.ConnectionStrings["ConnDB"].ConnectionString);
            SqlParameter[] paras = new SqlParameter[]{
                new SqlParameter("@search_key",InputItem.Str_SearchKey)
            };
            DataTable _dt = _SqlDbHelper.ExecuteDataTable("sp_get_deptlist_bykey", System.Data.CommandType.StoredProcedure, paras);

            List<Exchange_ReturnItem01> _list = new List<Exchange_ReturnItem01>();

            for (Int16 n = 0; n < _dt.Rows.Count; n++)
            {
                _list.Add(new Exchange_ReturnItem01() { Str_Name = _dt.Rows[n][0].ToString(), Str_Address = _dt.Rows[n][1].ToString() });
            }

            return _list;
        }

        [WebInvoke(UriTemplate = "Get_MeetingRoomList_byKey", Method = "POST", ResponseFormat = WebMessageFormat.Json)]
        public List<Exchange_ReturnItem01> Get_MeetingRoomList_byKey(Exchange_InputItem01 InputItem)
        {
            SqlDbHelper _SqlDbHelper = new SqlDbHelper(ConfigurationManager.ConnectionStrings["ConnDB"].ConnectionString);
            SqlParameter[] paras = new SqlParameter[]{
                new SqlParameter("@search_key",InputItem.Str_SearchKey)
            };
            DataTable _dt = _SqlDbHelper.ExecuteDataTable("sp_get_meetingroomlist_bykey", System.Data.CommandType.StoredProcedure, paras);

            List<Exchange_ReturnItem01> _list = new List<Exchange_ReturnItem01>();

            for (Int16 n = 0; n < _dt.Rows.Count; n++)
            {
                _list.Add(new Exchange_ReturnItem01() { Str_Name = _dt.Rows[n][0].ToString(), Str_Address = _dt.Rows[n][1].ToString() });
            }

            return _list;
        }

        [WebInvoke(UriTemplate = "Get_MeetingRoom_MainInfo_byKey", Method = "POST", ResponseFormat = WebMessageFormat.Json)]
        public List<Exchange_ReturnItem06> Get_MeetingRoom_MainInfo_byKey(Exchange_InputItem01 InputItem)
        {
            SqlDbHelper _SqlDbHelper = new SqlDbHelper(ConfigurationManager.ConnectionStrings["ConnDB_GIS"].ConnectionString);
            SqlParameter[] paras = new SqlParameter[]{
                new SqlParameter("@search_key",InputItem.Str_SearchKey)
            };
            DataTable _dt = _SqlDbHelper.ExecuteDataTable("sp_get_meetingroom_maininfo_bykey", System.Data.CommandType.StoredProcedure, paras);

            List<Exchange_ReturnItem06> _list = new List<Exchange_ReturnItem06>();

            for (Int16 n = 0; n < _dt.Rows.Count; n++)
            {
                _list.Add(new Exchange_ReturnItem06() { Str_Key = _dt.Rows[n][1].ToString(), 
                    Str_Value01 = _dt.Rows[n][0].ToString(),
                    Str_Value02 = _dt.Rows[n][2].ToString(),
                    Str_Value03 = _dt.Rows[n][3].ToString(),
                    Str_Value04 = _dt.Rows[n][4].ToString(),
                    Str_Value05 = ""
                });
            }

            return _list;
        }

        [WebInvoke(UriTemplate = "Get_Appointment_Schedule_by_MeetingRoom_StartTime_Duration", Method = "POST", ResponseFormat = WebMessageFormat.Json)]
        public List<Exchange_ReturnItem05> Get_Appointment_Schedule_by_MeetingRoom_StartTime_Duration(Exchange_InputItem03 InputItem)
        {
            Double tmp_i = 0;
            Double tmp_j=Convert.ToDouble(InputItem.Str_Duration);
            DateTime searchdtStart = DateTime.Parse(InputItem.Str_Date + " " + InputItem.Str_StartTime);
            List<Exchange_ReturnItem05> _list = new List<Exchange_ReturnItem05>();
            while (tmp_i < tmp_j)
            {
                searchdtStart=searchdtStart.AddHours(tmp_i);
                if (check_free_meetingroom(InputItem.Str_MeetingRoom_Address, searchdtStart.ToShortDateString() + " " + searchdtStart.ToShortTimeString(), 0.5))
                {
                    _list.Add(new Exchange_ReturnItem05()
                    {
                        Str_Key = "Free",
                        Str_Value = "Free"
                    });
                }
                else {
                    _list.Add(new Exchange_ReturnItem05()
                    {
                        Str_Key = "Busy",
                        Str_Value = "Busy"
                    });
                }
                tmp_i = tmp_i + 0.5;
            }
            

            return _list;
        }

        private static bool CertificateValidationCallBack(
           object sender,
           System.Security.Cryptography.X509Certificates.X509Certificate certificate,
           System.Security.Cryptography.X509Certificates.X509Chain chain,
           System.Net.Security.SslPolicyErrors sslPolicyErrors)
        {
            // If the certificate is a valid, signed certificate, return true.
            if (sslPolicyErrors == System.Net.Security.SslPolicyErrors.None)
            {
                return true;
            }

            // If there are errors in the certificate chain, look at each error to determine the cause.
            if ((sslPolicyErrors & System.Net.Security.SslPolicyErrors.RemoteCertificateChainErrors) != 0)
            {
                if (chain != null && chain.ChainStatus != null)
                {
                    foreach (System.Security.Cryptography.X509Certificates.X509ChainStatus status in chain.ChainStatus)
                    {
                        if ((certificate.Subject == certificate.Issuer) &&
                           (status.Status == System.Security.Cryptography.X509Certificates.X509ChainStatusFlags.UntrustedRoot))
                        {
                            // Self-signed certificates with an untrusted root are valid. 
                            continue;
                        }
                        else
                        {
                            if (status.Status != System.Security.Cryptography.X509Certificates.X509ChainStatusFlags.NoError)
                            {
                                // If there are any other errors in the certificate chain, the certificate is invalid,
                                // so the method returns false.
                                return false;
                            }
                        }
                    }
                }

                // When processing reaches this line, the only errors in the certificate chain are 
                // untrusted root errors for self-signed certificates. These certificates are valid
                // for default Exchange server installations, so return true.
                return true;
            }
            else
            {
                // In all other cases, return false.
                return false;
            }
        }
    }
}
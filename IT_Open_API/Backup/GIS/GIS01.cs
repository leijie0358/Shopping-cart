using System;
using System.Collections.Generic;
using System.Linq;
using System.ServiceModel;
using System.ServiceModel.Activation;
using System.ServiceModel.Web;
using System.Text;
using System.IO;
using System.Configuration;
using System.Data.SqlClient;
using System.Data;

namespace IT_Open_API
{
    [ServiceContract]
    [AspNetCompatibilityRequirements(RequirementsMode = AspNetCompatibilityRequirementsMode.Allowed)]
    [ServiceBehavior(InstanceContextMode = InstanceContextMode.PerCall)]

    public class GIS01
    {
        [WebInvoke(UriTemplate = "Navigation_ByPos", Method = "POST", ResponseFormat = WebMessageFormat.Json)]
        public GIS_ReturnItem Navigation_ByPos(GIS_InputItem01 InputItem)
        {
            SqlDbHelper _SqlDbHelper = new SqlDbHelper(ConfigurationManager.ConnectionStrings["ConnDB_GIS"].ConnectionString);
            SqlParameter[] paras = new SqlParameter[]{
                new SqlParameter("@s_pos_x",InputItem.s_pos_x),
                new SqlParameter("@s_pos_y",InputItem.s_pos_y),
                new SqlParameter("@d_pos_x",InputItem.d_pos_x),
                new SqlParameter("@d_pos_y",InputItem.d_pos_y),
                new SqlParameter("@result", SqlDbType.VarChar,8000)
            };
            paras[4].Direction = ParameterDirection.Output;
            _SqlDbHelper.ExecuteNonQuery("sp_get_floor_path_byPos", System.Data.CommandType.StoredProcedure, paras);
            // TODO: Replace the current implementation to return a collection of SampleItem instances
            return new GIS_ReturnItem() { Str_Return = paras[4].Value.ToString() };
        }

        [WebInvoke(UriTemplate = "Search_Entity_POS", Method = "POST", ResponseFormat = WebMessageFormat.Json)]
        public List<GIS_ReturnItem> Search_Entity_POS(GIS_InputItem02 InputItem)
        {
            SqlDbHelper _SqlDbHelper = new SqlDbHelper(ConfigurationManager.ConnectionStrings["ConnDB_GIS"].ConnectionString);
            SqlParameter[] paras = new SqlParameter[]{
                new SqlParameter("@search_key",InputItem.search_key)
            };
            DataTable _dt = _SqlDbHelper.ExecuteDataTable("sp_get_entity_pos", System.Data.CommandType.StoredProcedure, paras);
            List<GIS_ReturnItem> _list = new List<GIS_ReturnItem>();
            if (_dt.Rows.Count > 0)
            {
                GIS_ReturnItem _return = new GIS_ReturnItem();
                foreach(DataRow _dr in _dt.Rows)
                {
                    _list.Add(new GIS_ReturnItem()  { Str_Return = _dr[0].ToString() });
                }
                
            }
            else {
                _list.Add(new GIS_ReturnItem() { Str_Return = "ERR:用户不在本楼办公，无法定位！" });
                
            }
            return _list;
        }

        [WebInvoke(UriTemplate = "Load_MeetingRoom_POS_Status", Method = "POST", ResponseFormat = WebMessageFormat.Json)]
        public List<GIS_ReturnItem02> Load_MeetingRoom_POS_Status(GIS_InputItem02 InputItem)
        {

            List<GIS_ReturnItem02> _list = new List<GIS_ReturnItem02>();
            _list.Add(new GIS_ReturnItem02() { Str_Point = "418,280|500,307|480,363|399,337", Str_Status = "0" });
            _list.Add(new GIS_ReturnItem02() { Str_Point = "484,410|604,450|583,511|464,473", Str_Status = "0" });
            _list.Add(new GIS_ReturnItem02() { Str_Point = "609,451|729,491|707,552|588,513", Str_Status = "1" });
            
            return _list;
        }

        [WebInvoke(UriTemplate = "Load_User_DetailInfo_by_Empcode", Method = "POST", ResponseFormat = WebMessageFormat.Json)]
        public List<GIS_ReturnItem03> Load_User_DetailInfo_by_Empcode(GIS_InputItem02 InputItem)
        {
            List<GIS_ReturnItem03> _list = new List<GIS_ReturnItem03>();
            SqlDbHelper _SqlDbHelper = new SqlDbHelper(ConfigurationManager.ConnectionStrings["ConnDB_GIS"].ConnectionString);
            SqlParameter[] paras = new SqlParameter[]{
                new SqlParameter("@search_key",InputItem.search_key)
            };
            DataTable _dt = _SqlDbHelper.ExecuteDataTable("sp_get_User_DetailInfo", System.Data.CommandType.StoredProcedure, paras);
            if (_dt.Rows.Count > 0)
            {
                _list.Add(new GIS_ReturnItem03() { Str_Key = "员工编号", Str_Value = _dt.Rows[0]["empcode"].ToString() });
                _list.Add(new GIS_ReturnItem03() { Str_Key = "员工姓名", Str_Value = _dt.Rows[0]["c_name"].ToString() });
                _list.Add(new GIS_ReturnItem03() { Str_Key = "座位号", Str_Value = _dt.Rows[0]["posid"].ToString() });
                _list.Add(new GIS_ReturnItem03() { Str_Key = "分机号", Str_Value = _dt.Rows[0]["phone"].ToString() });
                _list.Add(new GIS_ReturnItem03() { Str_Key = "部门", Str_Value = _dt.Rows[0]["departname"].ToString() });
            }
            return _list;
        }

        
    }
}
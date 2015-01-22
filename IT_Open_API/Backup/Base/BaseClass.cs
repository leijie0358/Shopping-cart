using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.IO;
using System.Data.SqlClient;
using System.Data;

using System.DirectoryServices;

namespace IT_Open_API
{
    public class BaseClass
    {
        public static string strLoginKey = "";
        public static string strPassword = "";
        public static string str_path = System.AppDomain.CurrentDomain.BaseDirectory;

        public static string check_auth(string Signature, string Function_Name)
        {
            SqlDbHelper _SqlDbHelper = new SqlDbHelper();
            SqlParameter[] paras = new SqlParameter[]{
                new SqlParameter("@Signature",Signature),
                new SqlParameter("@Function_Name",Function_Name),
                new SqlParameter("@result", SqlDbType.VarChar, 100)
            };
            paras[2].Direction = ParameterDirection.Output;
            _SqlDbHelper.ExecuteNonQuery("sp_api_check_auth", System.Data.CommandType.StoredProcedure, paras);
            return paras[2].Value.ToString();
        }

        public static void WriteLog(string user_id, string fun_name, string str_msg, DateTime begin_dt)
        {
            try
            {
                insert_db_log(user_id, fun_name, str_msg, begin_dt);
            }
            catch (Exception ex)
            {
                WriteLog_TXT(DateTime.Now.ToLongDateString() + " " + DateTime.Now.ToLongTimeString() + "|" + user_id + "|" + str_msg + "(" + ex.Message.ToString() + ")");
            }
        }

        private static void insert_db_log(string user_id, string fun_name, string str_msg,DateTime begin_dt)
        {
            SqlDbHelper _SqlDbHelper = new SqlDbHelper();
            SqlParameter[] paras = new SqlParameter[]{
                new SqlParameter("@api_user_id",user_id),
                new SqlParameter("@api_fn_id",fun_name),
                new SqlParameter("@api_log_desc",str_msg),
                new SqlParameter("@api_begin_dt",begin_dt),
                new SqlParameter("@api_finish_dt",DateTime.Now),
                new SqlParameter("@result", SqlDbType.VarChar, 100)
            };
            paras[5].Direction = ParameterDirection.Output;
            _SqlDbHelper.ExecuteNonQuery("sp_api_write_log", System.Data.CommandType.StoredProcedure, paras);
        }

        private static void WriteLog_TXT(string str_msg)
        {
            FileStream fs = new FileStream(str_path + @"\Log\" + DateTime.Now.Year.ToString() + DateTime.Now.Month.ToString() + DateTime.Now.Day.ToString() + ".txt", FileMode.OpenOrCreate, FileAccess.Write);
            StreamWriter m_streamWriter = new StreamWriter(fs);
            m_streamWriter.BaseStream.Seek(0, SeekOrigin.End);
            m_streamWriter.WriteLine(str_msg);
            m_streamWriter.Flush();
            m_streamWriter.Close();
            m_streamWriter.Dispose();
            fs.Close();
            fs.Dispose();
        }

        public static DirectoryEntry make_AD_Entry(string cn)
        {
            string strDomain = "";
            string strLDAPPath = "";
            switch (cn)
            { 
                case "cn1":
                    strDomain = "cn1.global.ctrip.com";
                    strLDAPPath = "LDAP://cn1.global.ctrip.com/";
                    break;
                case "cn2":
                    strDomain = "cn2.global.ctrip.com";
                    strLDAPPath = "LDAP://cn2.global.ctrip.com/";
                    break;
                case "cn3":
                    strDomain = "cn3.global.ctrip.com";
                    strLDAPPath = "LDAP://cn3.global.ctrip.com/";
                    break;
                case "cn4":
                    strDomain = "cn4.global.ctrip.com";
                    strLDAPPath = "LDAP://cn4.global.ctrip.com/";
                    break;
                case "cn5":
                    strDomain = "cn5.global.ctrip.com";
                    strLDAPPath = "LDAP://cn5.global.ctrip.com/";
                    break;
            }
            string[] domains = strDomain.Split('.');
            foreach (string strString in domains)
            {
                strLDAPPath += string.Format("DC={0},", strString);
            }
            strLDAPPath = strLDAPPath.Trim(',');
            string strDomainAndUsername = @"cn1\" + strLoginKey;
            using (DirectoryEntry deEntry = new DirectoryEntry(strLDAPPath, strDomainAndUsername, strPassword, AuthenticationTypes.Secure))
            { 
                object obj = null;
                obj = (object)deEntry.NativeObject;
                return deEntry;
            }
        }

        public static SearchResultCollection search_AD_object(string filter, DirectoryEntry deEntry)
        {
            using (DirectorySearcher deSearch = new DirectorySearcher(deEntry))
            { 
                deSearch.Filter = filter;
                deSearch.PageSize = 1000;
                deSearch.SearchScope = SearchScope.Subtree;
                SearchResultCollection result = deSearch.FindAll();
                if (result != null)
                {
                    return result;
                }
                else
                {
                    return null;
                }
            }
        }
    }
}
using NativeWifi;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace Demo03
{
    public partial class Form1 : Form
    {
        public Boolean mylock1;
        System.Timers.Timer timer1;
        public List<WIFISSID> ssids = new List<WIFISSID>();

        public Form1()
        {
            InitializeComponent();
            timer1 = new System.Timers.Timer(30 * 1000);
            timer1.Elapsed += new System.Timers.ElapsedEventHandler(ScanBSS);
            timer1.AutoReset = true;
            mylock1 = false;
            System.Windows.Forms.Control.CheckForIllegalCrossThreadCalls = false;
            button1.Enabled = true;
            button2.Enabled = false;
        }

        public class WIFISSID { 
            public string SSID = "NONE"; 
            public string dot11DefaultAuthAlgorithm = ""; 
            public string dot11DefaultCipherAlgorithm = ""; 
            public bool networkConnectable = true; 
            public string wlanNotConnectableReason = ""; 
            public int wlanSignalQuality = 0; 
            public WlanClient.WlanInterface wlanInterface = null;    
        }

        static string GetStringForSSID(Wlan.Dot11Ssid ssid) { 
            return Encoding.UTF8.GetString(ssid.SSID, 0, (int)ssid.SSIDLength); 
        }  

        private void ScanSSID() {
            ssids.Clear();
            WlanClient client = new WlanClient();
            foreach (WlanClient.WlanInterface wlanIface in client.Interfaces) {
                Wlan.WlanAvailableNetwork[] networks = wlanIface.GetAvailableNetworkList(0);
                foreach (Wlan.WlanAvailableNetwork network in networks) {
                    WIFISSID targetSSID = new WIFISSID();
                    targetSSID.wlanInterface = wlanIface;
                    targetSSID.wlanSignalQuality = (int)network.wlanSignalQuality;
                    targetSSID.SSID = GetStringForSSID(network.dot11Ssid);
                    targetSSID.dot11DefaultAuthAlgorithm = network.dot11DefaultAuthAlgorithm.ToString();
                    targetSSID.dot11DefaultCipherAlgorithm = network.dot11DefaultCipherAlgorithm.ToString();
                    ssids.Add(targetSSID);
                }
            }
        }

        public void ScanBSS(object source, System.Timers.ElapsedEventArgs e)
        {
            mylock1 = true;
            SqlDbHelper _SqlDbHelper = new SqlDbHelper();
            string str_sql = "";


            StringBuilder _StringBuilder = new StringBuilder();
            WlanClient client = new WlanClient();
            foreach (WlanClient.WlanInterface wlanIface in client.Interfaces) {
                Wlan.WlanBssEntry[] bssworks = wlanIface.GetNetworkBssList();
                foreach (Wlan.WlanBssEntry bsswork in bssworks) {
                    str_sql = "insert into t_floor_wifi_point_tmp values (" + textBox2.Text + ",'" + GetStringForSSID(bsswork.dot11Ssid) + "','" + apmac(bsswork.dot11Bssid) + "'," + bsswork.rssi.ToString() + ")";
                    _SqlDbHelper.ExecuteNonQuery(str_sql);
                    _StringBuilder.AppendLine(
                        apmac(bsswork.dot11Bssid)
                        + "|" + GetStringForSSID(bsswork.dot11Ssid)
                        //+ "|" + bsswork.linkQuality.ToString()
                        + "|" + bsswork.rssi.ToString()
                        //+ "|" + bsswork.phyId.ToString()
                        //+ "|" + bsswork.wlanRateSet.ToString()
                        );
                }
            }
            textBox1.Text = _StringBuilder.ToString();
            mylock1 = false;
        }

        private string apmac(byte[] macaddr) {
            string tmac = "";
            for (int i = 0; i < macaddr.Length; i++) {
                tmac += macaddr[i].ToString("x2").PadLeft(2, '0').ToUpper();
            }
            return tmac;
        }

        private void WriteSSID() {
            StringBuilder _StringBuilder = new StringBuilder();
            foreach (WIFISSID targetSSID in ssids)
            {
                _StringBuilder.AppendLine(
                    targetSSID.wlanInterface + "|"
                    + targetSSID.wlanSignalQuality + "|"
                    + targetSSID.SSID + "|"
                    + targetSSID.dot11DefaultAuthAlgorithm + "|"
                    + targetSSID.dot11DefaultCipherAlgorithm);
            }
            textBox1.Text = _StringBuilder.ToString();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            SqlDbHelper _SqlDbHelper = new SqlDbHelper();

            string str_sql = "insert into t_floor_wifi_point_tmp values (1,'CORP','00E16DC83F0F',-64)";
            _SqlDbHelper.ExecuteNonQuery(str_sql);
            str_sql = "insert into t_floor_wifi_point_tmp values (1,'CORP','00E16DC83F0F',-640)";
            _SqlDbHelper.ExecuteNonQuery(str_sql);

            timer1.Start();
            button1.Enabled = false;
            button2.Enabled = true;
            MessageBox.Show("Begin");
        }

        private void button2_Click(object sender, EventArgs e)
        {
            if (mylock1 == false)
            {
                timer1.Stop();
                button1.Enabled = true;
                button2.Enabled = false;
                MessageBox.Show("Stop");
            }
            else {
                MessageBox.Show("正在扫描，请稍候！");
            }
        }
    }
}

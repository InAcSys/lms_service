using System.Text.Json.Serialization;
using LMSService.Domain.Entities.Abstracts;

namespace LMSService.Domain.Entities.Concretes
{
    public class Course : Entity<int>
    {

        [JsonPropertyName("sis_course_id")]
        public string? SisCourseId { get; set; }

        [JsonPropertyName("uuid")]
        public string Uuid { get; set; } = string.Empty;

        [JsonPropertyName("integration_id")]
        public string? IntegrationId { get; set; }

        [JsonPropertyName("sis_import_id")]
        public int? SisImportId { get; set; }

        [JsonPropertyName("name")]
        public string Name { get; set; } = string.Empty;

        [JsonPropertyName("course_code")]
        public string CourseCode { get; set; } = string.Empty;

        [JsonPropertyName("workflow_state")]
        public string WorkflowState { get; set; } = string.Empty;

        [JsonPropertyName("account_id")]
        public int AccountId { get; set; }

        [JsonPropertyName("root_account_id")]
        public int RootAccountId { get; set; }

        [JsonPropertyName("created_at")]
        public DateTime? CreatedAt { get; set; }

        [JsonPropertyName("start_at")]
        public DateTime? StartAt { get; set; }

        [JsonPropertyName("end_at")]
        public DateTime? EndAt { get; set; }

        [JsonPropertyName("total_students")]
        public int? TotalStudents { get; set; }

        [JsonPropertyName("calendar")]
        public CourseCalendar? Calendar { get; set; }

        [JsonPropertyName("course_progress")]
        public object? CourseProgress { get; set; }

        [JsonPropertyName("is_public")]
        public bool? IsPublic { get; set; }

        [JsonPropertyName("public_description")]
        public string? PublicDescription { get; set; }

        [JsonPropertyName("license")]
        public string? License { get; set; }

        [JsonPropertyName("time_zone")]
        public string TimeZone { get; set; } = string.Empty;
    }

    public class CourseCalendar
    {
        [JsonPropertyName("ics")]
        public string Ics { get; set; } = string.Empty;
    }
}
